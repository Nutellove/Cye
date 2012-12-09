@javascript
Feature: Answering the target's question during the culture entropy
  In order to write stealthily the answer the Cye should give
  As an initiated user
  I should be able to type something with a different predetermined display on-screen


Background:
  Given I am on the homepage
  And I fill in "question" with "Who am I ?"
  And I focus on the "culture" field
  And the expected culture input is "The only real valuable thing is intuition."


Scenario: Moving the caret around
  Given the "culture" field is empty
  When I type "The only real valuable thong[left][left]\bi[right][right] is intuition." in the "culture" field
  Then the "culture" field should contain "The only real valuable thing is intuition."

Scenario: Typing the answer
  Given the "culture" field is empty
  When I type "<lurove<ly real valuable thing is intuition." in the "culture" field
  Then the "culture" field should contain "The only real valuable thing is intuition."
  When I press "Ask"
  And I wait for 5 second
  Then I should see "lurove"

Scenario: Typing the answer, with backspaces
  Given the "culture" field is empty
  When I type "<li\burove<ly real valuable thing u\bis intuition." in the "culture" field
  Then the "culture" field should contain "The only real valuable thing is intuition."
  When I press "Ask"
  And I wait for 5 second
  Then I should see "lurove"