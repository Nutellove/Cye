Feature: Answering the target's question during step 2
  In order to write stealthily the answer the Cye should give
  As an initiated user
  I should be able to type something with a different predetermined display on-screen


Background:
  Given I am on the home page
  And I fill 'Who am I ?' in the question input
  And I am focused on the culture input
  And the expected culture input is 'The only real valuable thing is intuition.'

Scenario: Activating the Stealth Mode©
  Given the culture input is empty
  And the stealth mode is not activated
  When I type '<'
  Then the stealth mode should be activated
  And the culture input should be empty

Scenario: Deactivating the Stealth Mode©
  Given the stealth mode is activated
  When I type '<'
  Then the stealth mode should not be activated
  And the culture input should not end by '<'

Scenario: Filling the culture input
  Given the culture input is empty
  When I type '<lurove<ly real valuable thing is intuition.'
  Then the culture input should hold 'The only real valuable thing is intuition.'

Scenario: Submitting
  Given the culture input is empty
  When I type '<lurove<ly real valuable thing is intuition.'
  And I submit
  And I wait for 5 seconds
  Then I should see 'lurove'