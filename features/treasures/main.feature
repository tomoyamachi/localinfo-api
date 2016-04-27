@treasure
Feature: お宝一覧の取得とお宝詳細の取得をする
  @success
  Scenario: Get some treasures info
      When I send and accept JSON
      And I set form request body to:
      | limit    | 50  |
      | offset   | 1   |
      And I send a GET request to "treasures"
      Then the response status should be "200"
      And the JSON response root should be array
      And the JSON response element should follow "features/schemas/get_treasure.json"
      When I grab "$[0]['id']" as "treasure_id"
      And I send a GET request to "treasures/{treasure_id}"
      And the JSON response should follow "features/schemas/get_treasure.json"


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
      |       |      0 |    400 |
      |    -1 |     -1 |    400 |
      |    １ |      1 |    400 |
      |     1 |     １ |    400 |
      | limit | offset |    400 |
      |     0 |      0 |    400 |

  @success
  Scenario Outline: レビュー削除に不適切なIDを指定
    When I am logged in as "valid_token"
    And I send a DELETE request to "treasures/<treasure>"
    Then the response status should be "400"
    Examples:
      | treasure | review |
      |      -1 |      1 |
      |       0 |      1 |
      |       1 |      0 |
      |       1 |     -1 |



  @failure
  Scenario Outline: Check unsupported methods
    When I send and accept JSON
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
