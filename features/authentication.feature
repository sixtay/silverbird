Feature: Membership

   In order to give registered members access to exclusive content
   As an administrator
   I need authentication and registration for users

   Scenario: registration
     When I register "JohnDoe" "john@example.com"
     Then I should have an account
     