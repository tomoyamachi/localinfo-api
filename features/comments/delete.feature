@comment @login
Feature: ログインが必要な操作

  @success @delete
  Scenario: 自分が投稿したお宝情報を削除
    When I am logged in as "treasure_valid_token"
    And I send a GET request to "accounts/{account_id}/comments"
    And I grab "$['result'][0]['id']" as "comment_id"
    And I grab "$['result'][0]['treasure_id']" as "treasure_id"
    When I am logged in as "treasure_valid_token"
    And I send a DELETE request to "treasures/{treasure_id}/comments/{comment_id}"
    Then the response status should be "200"
    When I grab "$['success']" as "success"
    Then "success" should be equal "true"

  @failure @delete
  Scenario: ログインしていない場合は削除できない
    When I send and accept JSON
    And I send a DELETE request to "treasures/1/comments/1"
    Then the response status should be "403"

  @failure @delete
  Scenario: 自分のものでなければ削除できない
    When I am logged in as "treasure_valid_token"
    And I send a DELETE request to "treasures/1/comments/2"
    Then the response status should be "403"

  @success @put
  Scenario Outline: PUTの挙動を確認
    When I am logged in as "treasure_valid_token"
    And I send a GET request to "accounts/{account_id}/comments"
    Then the response status should be "200"
    When I grab "$['result'][0]['id']" as "comment_id"
    When I grab "$['result'][0]['treasure_id']" as "treasure_id"
    And I am logged in as "treasure_valid_token"
    And I set form request body to:
      | comment | うん。これで更新できたね。 |
    And I send a PUT request to "treasures/{treasure_id}/comments/{comment_id}"
    Then the response status should be "200"
    When I grab "$['success']" as "success"
    And I grab "$['comment']" as "comment"
    Then "success" should be equal "true"
    And "comment" should be equal "うん。これで更新できたね。"
    And the JSON response should have <optionality> key "<key>" of type <value type>
    Examples:
      | key     | value type | optionality |
      | id      | numeric    | required    |
      | success | boolean    | required    |

  @failure @put
  Scenario: ログインせずには更新できない
    When I send and accept JSON
    And I set form request body to:
      | comment | うん。これで更新できたね。 |
    And I send a PUT request to "treasures/1/comments/1"
    Then the response status should be "403"
