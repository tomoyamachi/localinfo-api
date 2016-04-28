@like @login
Feature: コメントを投稿

  @success
  Scenario: お宝情報を作成
    When I am logged in as "treasure_valid_token"
    And I send a POST request to "treasure/1/likes"
    Then the response status should be "200"
    And the JSON response should follow "features/schemas/get_like.json"

  @failure
  Scenario: ログインしていない場合は作成できない
    When I send and accept JSON
    And I send a POST request to "treasures/1/likes"
    Then the response status should be "302"

  @failure
  Scenario Outline: 不正なパラメータの場合も操作できない
    When I am logged in as "treasure_valid_token"
    And I send a POST request to "treasures/<treasure_id>/likes"
    Then the response status should be "<status>"
    Examples:
      | treasure_id | status |
      |           0 |    400 |
      |       10000 |    400 |
      |          -1 |    400 |
      |          １ |    400 |
      |       limit |    400 |
