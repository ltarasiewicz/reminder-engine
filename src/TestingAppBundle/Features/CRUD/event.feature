Feature: Perform CRUD operations on events
  In order to work with event data in client applications
  Developer should be able to
  Create, read, update and delete events

  Background:
    Given the database is empty
    And the fixtures file "bootstrap/basic_bootstrap.yml" is loaded

  Scenario: Read a collection of events
    When I send a GET request to "events"
    Then the response status code should be 200
    And the JSON node "root" should have 5 elements
    And the JSON node "root[0].guests" should have 2 elements
