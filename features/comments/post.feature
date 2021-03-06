@comment @login @tmp
Feature: コメントを投稿

  @success
  Scenario: お宝情報を作成
    When I am logged in as "localinfo_valid_token"
    And I set form request body to:
      | comment | コメント |
    And I send a POST request to "localinfos/1/comments"
    Then the response status should be "200"
    And the JSON response should follow "features/schemas/get_comment.json"

  @failure
  Scenario: ログインしていない場合は作成できない
    When I send and accept JSON
    And I set form request body to:
      | comment | コメント |
    And I send a POST request to "localinfos/1/comments"
    Then the response status should be "403"

  @failure
  Scenario Outline: 不正なパラメータの場合も操作できない
    When I am logged in as "localinfo_valid_token"
    And I set form request body to:
      | comment     | コメント      |
    And I send a POST request to "localinfos/<localinfo_id>/comments"
    Then the response status should be "<status>"
    Examples:
      | localinfo_id | status |
      |           0 |    400 |
      |          -1 |    400 |
      |          １ |    404  |
      |       limit |    404  |

  @failure
  Scenario Outline: 不正なパラメータの場合も操作できない
    When I am logged in as "localinfo_valid_token"
    And I set form request body to:
      | comment | comment |
    And I send a POST request to "localinfos/<localinfo_id>/comments"
    Then the response status should be "<status>"
    And I grab "$['success']" as "success"
    Then "success" should be equal "<success>"
    Examples:
      | localinfo_id | status | success |
      |       10000 |    200 | false   |
      |           1 |    200 | true    |
