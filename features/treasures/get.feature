@treasure
Feature: お宝一覧の取得とお宝詳細の取得をする
  @success @tmp
  Scenario: Get some treasures info
      When I send and accept JSON
      And I send a GET request to "treasures?limit=10&offset=0"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_treasures.json"
      When I grab "$['result'][0]['id']" as "treasure_id"
      And I send a GET request to "treasures/{treasure_id}"
      And the JSON response should follow "features/schemas/get_treasure.json"

  @success @tmp
  Scenario: Get some treasures info with total count
      When I send and accept JSON
      And I send a GET request to "treasures?limit=10&offset=0&total=1"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_treasures.json"
      And the JSON response should have required key "total" of type numeric


  @failure
  Scenario Outline: Invalid offset setting
      When I send and accept JSON
      And I send a GET request to "treasures?limit=<limit>&offset=<offset>"
      Then the response status should be "<status>"
    Examples:
      | limit | offset | status |
      |    -1 |      1 |    400 |
      |     0 |      1 |    400 |
      |     1 |      1 |    200 |
      |    50 |     -1 |    400 |
      |    -1 |     -1 |    400 |
      |    １ |      1 |    400 |
      |     1 |     １ |    400 |
      | limit | offset |    400 |
      |     0 |      0 |    400 |

  @failure
  Scenario Outline: Check unsupported methods
    when I send and accept JSON
    And I send a <method> request to "<action>"
    Then the response status should be "<status>"
    Examples:
      | method | status | action                     |
      | PUT    |    405 | treasures                   |
      | DELETE |    405 | treasures                   |
      | POST   |    405 | treasures/1                 |
      | DELETE |    405 | treasures/1                 |
      | GET    |    404 | treasures/１                |
      | GET    |    404 | treasures/sampleId          |
      | GET    |    400 | treasures/-1                |
      | GET    |    400 | treasures/0                 |
      | GET    |    400 | treasures/99999999999999999 |

  @failure
  Scenario Outline: 指定したIDのお宝が不正だった場合
    When I send and accept JSON
    And I send a GET request to "treasures/<treasure_id>"
    Then the response status should be "<status>"
    Examples:
      | treasure_id | status |
      |          -1 |    400 |
      |           0 |    400 |
      |      100000 |    200 |
