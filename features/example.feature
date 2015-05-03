Feature: Testing
   In order to teach Behat
   As a teacher
   I want to demonstrate how to install and create features

   Scenario: Home page
      Given I am on the homepage
      Then I should see "Laravel 5"


   Scenario: Dashboard is locked to guests
      When I go to "home"
      Then the url should match "auth/login"
      And I can do something with laravel
      