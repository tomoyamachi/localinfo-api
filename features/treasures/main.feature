@treasure
Feature: Get treasures datas
  @success
  Scenario: Get some treasures info
      When I send and accept JSON
      And I set form request body to:
      | limit    | 50  |
      | offset   | 1   |
      And I send a GET request to "treasures"
      Then the response status should be "200"
      # When I grab "$['success']" as "success"
      # Then "success" should be equal "false"
      And the JSON response root should be array
      And the JSON response element should follow "features/schemas/get_treasure.json"
