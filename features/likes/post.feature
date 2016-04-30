@like @login
Feature: コメントを投稿

  @success
  Scenario: お宝情報を作成
    When I am logged in as "treasure_valid_token"
    And I send a POST request to "treasures/1/likes"
    Then the response status should be "200"
    And the JSON response should follow "features/schemas/get_like.json"

  @failure
  Scenario: ログインしていない場合は作成できない
    When I send and accept JSON
    And I send a POST request to "treasures/1/likes"
    Then the response status should be "403"

  @failure
  Scenario Outline: 不正なパラメータの場合も操作できない
    When I am logged in as "treasure_valid_token"
    And I send a POST request to "treasures/<treasure_id>/likes"
    Then the response status should be "<status>"
    Examples:
      | treasure_id | status |
      |           0 |    400 |
      |          -1 |    400 |
      |          １ |    404  |
      |       limit |    404  |


  @failure
  Scenario Outline: 存在しないパラメータの場合も操作できない
    When I am logged in as "treasure_valid_token"
    And I send a POST request to "treasures/<treasure_id>/likes"
    Then the response status should be "<status>"
    And I grab "$['success']" as "success"
    Then "success" should be equal "<success>"
    Examples:
      | treasure_id | status | success |
      |       10000 |    200 | false   |
      |           1 |    200 | true    |
