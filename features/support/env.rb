# coding: utf-8

# cucumber {options} DOMAIN="http://sample.com/" で指定されたドメインへapiを送信
ENV['DOMAIN'] ||= 'localhost:8080/v1/'
$BASEURL = ENV['DOMAIN']
puts 'baseURL:'+$BASEURL
