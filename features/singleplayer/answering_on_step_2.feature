Feature: Answering the target's question during step 2
  In order to write stealthily the answer the Eye should give
  As an initiated user
  I should be able to type something with a different display on-screen

Scenario: Activating the Stealth Mode©
  Given the step 2 input text field is empty
  And the stealth mode is not activated
  When I type '<' in the step 2 input text field
  Then the stealth mode should be activated
