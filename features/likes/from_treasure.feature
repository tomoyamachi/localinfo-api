@treasure @like
Feature: お宝に紐づくコメントを取得
  @success
  Scenario: 存在するお宝に紐づくコメントを取得
      When I send and accept JSON
      And I send a GET request to "treasures"
      Then the response status should be "200"
      When I grab "$['result'][0]['id']" as "treasure_id"
      And I send a GET request to "treasures/{treasure_id}/likes"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_likes.json"
