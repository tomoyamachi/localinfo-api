@treasure @comment
Feature: お宝に紐づくコメントを取得
  @success
  Scenario: 存在するお宝に紐づくコメントを取得
      When I send and accept JSON
      And I send a GET request to "treasures"
      Then the response status should be "200"
      When I grab "$['result'][0]['id']" as "treasure_id"
      And I send a GET request to "treasures/{treasure_id}/comments"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_comments.json"
      When I grab "$['result'][0]['id']" as "comment_id"
      And I grab "$['result'][0]['treasure_id']" as "treasure_id"
      And I send a GET request to "treasures/{treasure_id}/comments/{comment_id}"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_comment.json"
