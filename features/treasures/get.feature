@localinfo @get
Feature: お宝一覧の取得とお宝詳細の取得をする
  @success
  Scenario: Get some localinfos info
      When I send and accept JSON
      And I send a GET request to "localinfos?limit=10&offset=0"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_localinfos.json"
      When I grab "$['result'][0]['id']" as "localinfo_id"
      And I send a GET request to "localinfos/{localinfo_id}"
      And the JSON response should follow "features/schemas/get_localinfo.json"

  @success
  Scenario: Get some localinfos info with total count
      When I send and accept JSON
      And I send a GET request to "localinfos?limit=10&offset=0&total=1"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_localinfos.json"
      And the JSON response should have required key "total" of type numeric


  @failure
  Scenario Outline: Check unsupported methods
    when I send and accept JSON
    And I send a <method> request to "<action>"
    Then the response status should be "<status>"
    Examples:
      | method | status | action                     |
      | PUT    |    405 | localinfos                   |
      | DELETE |    405 | localinfos                   |
      | POST   |    405 | localinfos/1                 |
      | GET    |    404 | localinfos/１                |
      | GET    |    404 | localinfos/sampleId          |
      | GET    |    400 | localinfos/-1                |
      | GET    |    400 | localinfos/0                 |
      | GET    |    400 | localinfos/99999999999999999 |

  @failure
  Scenario Outline: 指定したIDのお宝が不正だった場合
    When I send and accept JSON
    And I send a GET request to "localinfos/<localinfo_id>"
    Then the response status should be "<status>"
    Examples:
      | localinfo_id | status |
      |          -1 |    400 |
      |           0 |    400 |
      |      100000 |    400 |
