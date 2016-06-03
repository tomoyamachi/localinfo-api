@localinfo @like
Feature: お宝に紐づくコメントを取得
  @success
  Scenario: 存在するお宝に紐づくコメントを取得
      When I send and accept JSON
      And I send a GET request to "localinfos"
      Then the response status should be "200"
      When I grab "$['result'][0]['id']" as "localinfo_id"
      And I send a GET request to "localinfos/{localinfo_id}/likes"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_likes.json"
