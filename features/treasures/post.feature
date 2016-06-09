@localinfo @login @post
Feature: お宝を作成
  @success @tmp
  Scenario: お宝情報を作成
    When I am logged in as "localinfo_valid_token"
    And I set form request body to:
      | title           | テスト投稿                          |
      | prefecture_id | 1                                   |
      | area_id       | 1                                   |
      | comment         | よいよい                            |
      | main           | file://features/support/sample.jpeg |
      | sub1           | file://features/support/sample.jpeg |
      | sub2           | file://features/support/sample.jpeg |
    And I send a POST request to "localinfos"
    Then the response status should be "200"
    And the JSON response should follow "features/schemas/get_localinfo.json"

  @failure
  Scenario: ログインしていない場合は作成できない
    When I send and accept JSON
    And I set form request body to:
      | title           | テスト投稿                          |
      | prefecture_id |                             1 |
      | area_id       |                             1 |
      | comment         |                      よいよい |
      | image           | file://features/support/sample.jpeg |
    And I send a POST request to "localinfos"
    Then the response status should be "403"

  @failure
  Scenario Outline: 不正なパラメータの場合も操作できない
    When I am logged in as "localinfo_valid_token"
    And I set form request body to:
      | title           | テスト投稿                          |
      | prefecture_id | <m_prefecture_id>             |
      | area_id       | <m_area_id>                   |
      | comment         | comment                       |
      | image           | file://features/support/sample.jpeg |
    And I send a POST request to "localinfos"
    Then the response status should be "<status>"
    And I grab "$['success']" as "success"
    Then "success" should be equal "<success>"
    Examples:
      | m_prefecture_id | m_area_id | status | success |
      |               1 |         1 |    200 | true   |
      |               4   |         1 |    200 | true   |
      |               0 |         1 |    200 | false   |
      |           10000 |         1 |    200 | false   |
      |              50 |        -1 |    200 | false   |
      |                 |         0 |    200 | false   |
      |              -1 |        -1 |    200 | false   |
      |              １ |         1 |    200 | false   |
      |               1 |        １ |    200 | false   |
      |           limit |    offset |    200 | false   |
      |               0 |         0 |    200 | false   |
