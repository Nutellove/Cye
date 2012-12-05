@javascript
Feature: Answering the target's question during step 2
  In order to write stealthily the answer the Cye should give
  As an initiated user
  I should be able to type something with a different predetermined display on-screen

Background:
  Given I am on the homepage
  And I fill in "question" with "Who am I ?"
  And I focus on the "culture" field
  And the expected culture input is "The only real valuable thing is intuition."


#Scenario: Activating the Stealth Mode©
#  Given the "culture" field is empty
#  And the stealth mode is not activated
#  And I focus on the "culture" field
#  When I type "<"
#  Then the stealth mode should be activated
#  And the "culture" field should be empty
#
#Scenario: Deactivating the Stealth Mode©
#  Given the stealth mode is activated
#  When I type "<"
#  Then the stealth mode should not be activated
#  And the "culture" field should not end by "<"

Scenario: Filling the culture input
  Given the "culture" field is empty
  And I focus on the "culture" field
  When I type "<lurove<ly real valuable thing is intuition." in the "culture" field
  Then the "culture" field should contain "The only real valuable thing is intuition."

Scenario: Submitting
  Given the "culture" field is empty
  When I type "<lurove<ly real valuable thing is intuition." in the "culture" field
  And I submit
  And I wait for 5 seconds
  Then I should see "lurove"