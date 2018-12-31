Feature: Homepage Privacy Policy Test
    In order to accomplish the mequilibrium test
    I need to see the homepage privacy page

    Scenario: Check privacy content
        Given: I have a web browser
        When I load the homepage
        Then I should see "privacy"
        And I should see a "PRIVACY [UPDATED]" link
        And I click the "PRIVACY [UPDATED]" link
        And I should see "Last Updated: May 24, 2018"