@prefecture
Feature: 対象の県のお宝情報
  @success
  Scenario: Get some prefectures info
      When I send and accept JSON
      And I send a GET request to "prefectures/1/treasures"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_treasures.json"
      When I grab "$['result'][0]['prefecture_id']" as "prefecture_id"
      Then "prefecture_id" should be equal "1"
      When I grab "$['result'][1]['prefecture_id']" as "prefecture_id"
      Then "prefecture_id" should be equal "1"

  @success
  Scenario: Get some areas info
      When I send and accept JSON
      And I send a GET request to "prefectures/1/areas/2/treasures"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_treasures.json"
      When I grab "$['result'][0]['area_id']" as "area_id"
      Then "area_id" should be equal "2"
      When I grab "$['result'][1]['area_id']" as "area_id"
      Then "area_id" should be equal "2"
