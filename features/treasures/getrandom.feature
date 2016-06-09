@localinfo @get
Feature: 通常以外のご当地情報取得
  @success
  Scenario: ランダムに指定した数のお宝を取得
      When I send and accept JSON
      And I send a GET request to "localinfos/random"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_localinfos.json"

  @success
  Scenario: 指定した場所付近のお宝を取得
      When I send and accept JSON
      And I send a GET request to "localinfos/near/1"
      Then the response status should be "200"
      And the JSON response should follow "features/schemas/get_localinfos.json"
