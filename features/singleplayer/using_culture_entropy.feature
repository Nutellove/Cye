@javascript
Feature: Answering the target's question during the culture entropy
  In order to write stealthily the answer the Cye should give
  As an initiated user
  I should be able to type something underhandedly


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
   When I type "<Antoine<y real valuable thing is intuition." in the "culture" field
   Then the "culture" field should contain "The only real valuable thing is intuition."
   When I press "Ask"
    And I wait for 5 second
   Then I should see "Antoine"


Scenario: Typing the answer, with backspaces
  Given the "culture" field is empty
   When I type "<Aj\bntoine<y real valuable thing u\bis intuition." in the "culture" field
   Then the "culture" field should contain "The only real valuable thing is intuition."
   When I press "Ask"
    And I wait for 5 second
   Then I should see "Antoine"


Scenario: Typing a keyword to a pre-made answer
  Given the "culture" field is empty
#   And there is a data file named "test" containing "I am merely a test."
   When I type "<test<only real valuable thing is intuition." in the "culture" field
   Then the "culture" field should contain "The only real valuable thing is intuition."
   When I press "Ask"
    And I wait for 10 second
   Then I should see "I am merely a test."


# Now you know everything…
# As usual, the power was always within you.
# Farewell!
