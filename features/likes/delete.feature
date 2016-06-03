@like @login @delete
Feature: ログインが必要な操作

  @success
  Scenario: 自分が投稿したお宝情報を削除
    When I am logged in as "localinfo_valid_token"
    And I send a GET request to "accounts/{account_id}/likes"
    And I grab "$['result'][0]['id']" as "like_id"
    And I grab "$['result'][0]['localinfo_id']" as "localinfo_id"
    When I am logged in as "localinfo_valid_token"
    And I send a DELETE request to "localinfos/{localinfo_id}/likes/{like_id}"
    Then the response status should be "200"
    When I grab "$['success']" as "success"
    Then "success" should be equal "true"

  @failure
  Scenario: ログインしていない場合は削除できない
    When I send and accept JSON
    And I send a DELETE request to "localinfos/1/likes/1"
    Then the response status should be "403"

  @failure
  Scenario: 自分のものでなければ削除できない
    When I am logged in as "localinfo_valid_token"
    And I send a DELETE request to "localinfos/1/likes/2"
    Then the response status should be "403"
