@prefecture
Feature: 県一覧と県個別情報の取得
  @success
  Scenario: Get some prefectures info
      When I send and accept JSON
      And I send a GET request to "prefectures"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_prefectures.json"
      When I grab "$['result'][0]['id']" as "prefecture_id"
      And I send a GET request to "prefectures/{prefecture_id}"
      And the JSON response should follow "features/schemas/get_prefecture.json"

  @success
  Scenario: Get some prefectures info with total count
      When I send and accept JSON
      And I send a GET request to "prefectures?limit=10&offset=0&total=1"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_prefectures.json"
      And the JSON response should have required key "total" of type numeric


  @success
  Scenario: Get some areas info
      When I send and accept JSON
      And I send a GET request to "prefectures"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_prefectures.json"
      When I grab "$['result'][0]['id']" as "prefecture_id"
      And I send a GET request to "prefectures/{prefecture_id}/areas"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_areas.json"
      When I grab "$['result'][0]['id']" as "area_id"
      When I grab "$['result'][0]['prefecture_id']" as "prefecture_id"
      And I send a GET request to "prefectures/{prefecture_id}/areas/{area_id}"
      And the JSON response should follow "features/schemas/get_area.json"


  @failure
  Scenario Outline: Invalid prefecture id
      When I send and accept JSON
      And I send a GET request to "prefectures/<prefecture_id>"
      Then the response status should be "<status>"
    Examples:
      | prefecture_id | status |
      |            -1 |    400 |
      |             0 |    400 |
      |             1 |    200 |
      |           100 |    400 |
      |            １ |    404  |
      |               |    404  |
      |         limit |    404  |

  @failure
  Scenario Outline: Invalid area id
      When I send and accept JSON
      And I send a GET request to "prefectures/<prefecture_id>/areas/<area_id>"
      Then the response status should be "<status>"
    Examples:
      | prefecture_id |    area_id | status |
      |             1 |          1 |    200 |
      |             1 |         -1 |    400 |
      |             1 |          0 |    400 |
      |             1 | 9999999999 |    400 |
      |             1 |       hoge |    404  |
      |             1 |         １ |    404  |
