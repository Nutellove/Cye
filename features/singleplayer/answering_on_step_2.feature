Feature: Answering the target's question during step 2
  In order to write stealthily the answer the Cye should give
  As an initiated user
  I should be able to type something with a different predetermined display on-screen

# step 2 input text field => find a better name

Background:
  Given I am on the question page
  And I am focused on the step 2 input text field
  And the expected step 2 answer is 'Please answer me'

Scenario: Activating the Stealth Mode©
  Given the step 2 input text field is empty
  And the stealth mode is not activated
  When I type '<'
  Then the stealth mode should be activated

Scenario:
  Given the step 2 input text field is empty
  When I type '<s3cret< answer me'
  Then the step 2 input text field should hold 'Please answer me'

Scenario:
  Given the step 2 input text field is empty
  When I type '<s3cret< answer me'
  And I submit
  Then I should see 's3cret'