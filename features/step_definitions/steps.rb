# coding: utf-8
# https://github.com/hidroh/cucumber-api/tree/master/lib
# ほぼcucumber-apiのコード。
# 以下のメソッドを他のファイルに移動ずみ。
require_relative './response'
require 'rest-client'
require 'json-schema'

if ENV['cucumber_api_verbose'] == 'true'
  RestClient.log = 'stdout'
end

$cache = {}

Given(/^I send and accept JSON$/) do
  steps %Q{
    Given I send "application/json" and accept JSON
  }
end

Given(/^I send "(.*?)" and accept JSON$/) do |content_type|
  @headers = {
      :Accept => 'application/json',
      :'Content-Type' => %/#{content_type}/
  }
end

When(/^I set JSON request body to '(.*?)'$/) do |body|
  @body = JSON.parse body
end

When(/^I set form request body to:$/) do |params|
  @body = {}
  params.rows_hash.each do |key, value|
    p_value = value
    @grabbed.each { |k, v| p_value = v if value == %/{#{k}}/ } unless @grabbed.nil?
    p_value = File.new %-#{Dir.pwd}/#{p_value.sub 'file://', ''}- if %/#{p_value}/.start_with? "file://"
    @body[%/#{key}/] = p_value
  end
end

When(/^I set request body from "(.*?).(yml|json)"$/) do |filename, extension|
  path = %-#{Dir.pwd}/#{filename}.#{extension}-
  if File.file? path
    case extension
      when 'yml'
        @body = YAML.load File.open(path)
      when 'json'
        @body = JSON.parse File.read(path)
      else
        raise %/Unsupported file type: '#{path}'/
    end
  else
    raise %/File not found: '#{path}'/
  end
end


When(/^I grab "(.*?)" as "(.*?)"$/) do |json_path, place_holder|
  if @response.nil?
    raise 'No response found, a request need to be made first before you can grab response'
  end

  @grabbed = {} if @grabbed.nil?
  @grabbed[%/#{place_holder}/] = @response.get json_path
end

Then(/^the response status should be "(\d+)"$/) do |status_code|
  raise %/Expect #{status_code} but was #{@response.code}/ if @response.code != status_code.to_i
end

Then(/^the JSON response should follow "(.*?)"$/) do |schema|
  file_path = %-#{Dir.pwd}/#{schema}-
  if File.file? file_path
    begin
      JSON::Validator.validate!(file_path, @response.to_s)
    rescue JSON::Schema::ValidationError => e
      raise JSON::Schema::ValidationError.new(%/#{$!.message}\n#{@response.to_json_s}/,
                                              $!.fragments, $!.failed_attribute, $!.schema)
    end
  else
    puts %/WARNING: missing schema '#{file_path}'/
    pending
  end
end

Then(/^the JSON response root should be (object|array)$/) do |type|
  steps %Q{
    Then the JSON response should have required key "$" of type #{type}
  }
end

Then(/^the JSON response should have key "([^\"]*)"$/) do |json_path|
  steps %Q{
    Then the JSON response should have required key "#{json_path}" of type any
  }
end

Then(/^the JSON response should have (required|optional) key "(.*?)" of type \
(numeric|string|array|boolean|numeric_string|object|array|any)( or null)?$/) do |optionality, json_path, type, null_allowed|
  next if optionality == 'optional' and not @response.has(json_path)  # if optional and no such key then skip
  if 'any' == type
    @response.get json_path
  elsif null_allowed.nil?
    @response.get_as_type json_path, type
  else
    @response.get_as_type_or_null json_path, type
  end
end

# Bind grabbed values into placeholders in given URL
# Ex: http://example.com?id={id} with {id => 1} becomes http://example.com?id=1
# @param url [String] parameterized URL with placeholders
# @return [String] binded URL or original URL if no placeholders
def resolve url
  unless @grabbed.nil?
    @grabbed.each { |key, value| url = url.gsub /\{#{key}\}/, %/#{value}/ }
  end
  url
end
