@account @like
Feature: アカウントに紐づくコメントを取得
  @success
  Scenario: 指定したユーザーがしたいいねを取得
    When I am logged in as "treasure_valid_token"
    And I send a GET request to "accounts/{account_id}/likes"
    Then the response status should be "200"
    And the JSON response should follow "features/schemas/get_likes.json"
