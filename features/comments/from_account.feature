@account @comment
Feature: アカウントに紐づくコメントを取得
  @success
  Scenario: 指定したユーザーが投稿したコメントを取得
    When I am logged in as "localinfo_valid_token"
    And I send a GET request to "accounts/{account_id}/comments"
    Then the response status should be "200"
    And the JSON response should follow "features/schemas/get_comments.json"
