# coding: utf-8
# cucumber-apiではglobal variableが利用できないのでこちらで作成
When(/^I send a (GET|POST|PATCH|PUT|DELETE) request to "(.*?)" with:$/) do |method, url, params|
  unless params.hashes.empty?
    query = params.hashes.first.map{|key, value| %/#{key}=#{value}/}.join("&")
    if url.include?('?')
      url = $BASEURL+url+"&"+query
    else
      url = $BASEURL+url+"?"+query
    end
  end
  puts url
  steps %Q{
      When I send a #{method} request to "#{url}"
    }
end


When(/^I send a (GET|POST|PATCH|PUT|DELETE) request to "(.*?)"$/) do |method, url|
  concatUrl = $BASEURL+url
  if @account_id.nil?
    request_url = URI.encode resolve(concatUrl)
  else
    request_url = URI.encode resolve(concatUrl.sub(/{account_id}/,@account_id.to_s))
  end
  # puts request_url

  # 同じURLでも認証状況によってレスポンスが変わるので、キャッシュ化しない
  # if 'GET' == %/#{method}/ and $cache.has_key? %/#{request_url}/
  #   @response = $cache[%/#{request_url}/]
  #   @headers = nil
  #   @body = nil
  #   @grabbed = nil
  #   next
  # end

  @headers = {} if @headers.nil?
  begin
    case method
      when 'GET'
        response = RestClient.get request_url, @headers
      when 'POST'
        response = RestClient.post request_url, @body, @headers
      when 'PATCH'
        response = RestClient.patch request_url, @body, @headers
      when 'PUT'
        response = RestClient.put request_url, @body, @headers
      else
        response = RestClient.delete request_url, @headers
    end
  rescue RestClient::Exception => e
    response = e.response
  end
  @response = CucumberApi::Response.create response
  # DEBUG用 : responseを表示
  puts @response
  @headers = nil
  @body = nil
  @grabbed = nil
  $cache[%/#{request_url}/] = @response if 'GET' == %/#{method}/
end

Then(/^"(.*?)" should be equal "(.*?)"$/) do |key, value|
  if @grabbed.nil?
    raise %/Undefined key: '#{key}'/
  else
    # 型比較でboolean型などがあるので、jsonの値を文字列に変換して比較
    raise %/Expect #{value} but was #{@grabbed[key]}/ if @grabbed[key].to_s != value
  end
end

# 指定したセッションにユーザー情報を保存
Given /^I am logged in as "(.*)"$/ do |email|
  if $current_session.nil?
    $current_session = (0...8).map { (65 + rand(26)).chr }.join
  end

  @headers = {
              :Accept => 'application/json',
              :'Content-Type' => 'application/json',
              :Cookie => 'PHPSESSID='+$current_session,
  }

  @body = {
    :login_token => 'valid_token',
    :app_code => 'gcpn',
  }

  request_url = $BASEURL+'login'

  # JSONレスポンスをパースしてアカウントIDを指定する
  response = RestClient.post request_url, @body, @headers
  @response = CucumberApi::Response.create response
  parsed = JSON.parse @response
  # puts @response
  @account_id = parsed['account_id']
  @body = nil
  @headers = {
              :Accept => 'application/json',
              :'Content-Type' => 'application/json',
              :Cookie => 'PHPSESSID='+$current_session,
  }
end


# 配列で入ってくる要素の子要素が対象のフォーマットになっているか確認
Then(/^the JSON response element should follow "(.+?)"$/) do |schema|
    element_response = @response.get "$[0]"
    # puts element_response.to_json
    file_path = %-#{Dir.pwd}/#{schema}-
    if File.file? file_path
      begin
        JSON::Validator.validate!(file_path, element_response.to_json)
      rescue JSON::Schema::ValidationError => e
        raise JSON::Schema::ValidationError.new(%/#{$!.message}\n#{element_response.to_json}/,
                                                $!.fragments, $!.failed_attribute, $!.schema)
      end
    else
      puts %/WARNING: missing schema '#{file_path}'/
      pending
    end
end
