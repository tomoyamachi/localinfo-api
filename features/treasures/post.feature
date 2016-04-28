@treasure @login
Feature: お宝を作成

  @success
  Scenario: お宝情報を作成
    When I am logged in as "treasure_valid_token"
    And I set form request body to:
      | m_prefecture_id |                             1 |
      | m_area_id       |                             1 |
      | comment            |                      よいよい |
      | image           | file://../support/sample.jpeg |
    And I send a POST request to "treasures"
    Then the response status should be "200"
    And the JSON response should follow "features/schemas/get_treasure.json"

  @failure
  Scenario: ログインしていない場合は作成できない
    When I send and accept JSON
    And I set form request body to:
      | m_prefecture_id |                             1 |
      | m_area_id       |                             1 |
      | comment         |                      よいよい |
      | image           | file://../support/sample.jpeg |
    And I send a POST request to "treasures"
    Then the response status should be "302"

  @failure
  Scenario Outline: 不正なパラメータの場合も操作できない
    When I am logged in as "treasure_valid_token"
    And I set form request body to:
      | m_prefecture_id | <m_prefecture_id>             |
      | m_area_id       | <m_area_id>                   |
      | comment         | comment                       |
      | image           | file://../support/sample.jpeg |
    And I send a POST request to "treasures"
    Then the response status should be "<status>"
    Examples:
      | m_prefecture_id | m_area_id | status |
      |               0 |         1 |    400 |
      |           10000 |         1 |    400 |
      |               1 |         1 |    200 |
      |              50 |        -1 |    400 |
      |                 |         0 |    400 |
      |              -1 |        -1 |    400 |
      |              １ |         1 |    400 |
      |               1 |        １ |    400 |
      |           limit |    offset |    400 |
      |               0 |         0 |    400 |
