# coding: utf-8

# cucumber {options} DOMAIN="http://sample.com/" で指定されたドメインへapiを送信
ENV['DOMAIN'] ||= 'http://api.treasure.prod.amachi.rznapp.com/v1/'
$BASEURL = ENV['DOMAIN']
puts 'baseURL:'+$BASEURL
