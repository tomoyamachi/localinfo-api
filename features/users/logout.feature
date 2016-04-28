@logout
Feature: ログアウト

  @success
  Scenario: ログアウト
    When I send and accept JSON
    And I send a POST request to "logout"
    Then the response status should be "200"

  @failure
  Scenario Outline: Check unsupported methods
    When I send and accept JSON
    And I send a <method> request to "logout"
    Then the response status should be "405"
    Examples:
      | method |
      | GET    |
      | PUT    |
      | DELETE |
