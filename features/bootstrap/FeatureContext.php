<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

// Require 3rd-party libraries here:
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    protected function execJs ($script)
    {
        $this->getSession()->executeScript($script);
    }

    protected function evalJs ($script)
    {
        return $this->getSession()->evaluateScript($script);
    }


    /**
     * @Given /^I focus on the "(?P<field>(?:[^"]|\\")*)" field$/
     */
    public function iFocusOnTheField($field)
    {
        $this->execJs("document.getElementById('{$field}_input').focus();");
    }

    /**
     * @Given /^the expected culture input is \"([^\"]*)\"$/
     */
    public function theExpectedCultureInputIs($value)
    {
        $this->execJs("document.getElementById('answer_expected').innerHTML = '{$value}';");
    }





    /**
     * @Given /^I submit$/
     */
    public function iSubmit()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I wait for (\d+) seconds$/
     */
    public function iWaitForSeconds($how_many)
    {
        throw new PendingException();
    }

    /**
     * @Given /^the stealth mode is not activated$/
     */
    public function theStealthModeIsNotActivated()
    {
        throw new PendingException();
    }

    /**
     * @Given /^the stealth mode is activated$/
     */
    public function theStealthModeIsActivated()
    {
        throw new PendingException();
    }

    /**
     * @Then /^the stealth mode should be activated$/
     */
    public function theStealthModeShouldBeActivated()
    {
        throw new PendingException();
    }

    /**
     * @Then /^the stealth mode should not be activated$/
     */
    public function theStealthModeShouldNotBeActivated()
    {
        throw new PendingException();
    }


    /** TRAIT: TYPING *************************************************************************************************/

    /**
     * @When /^I type \"([^\"]+)\"$/
     */
    public function iType($string)
    {
        $characters = str_split($string);

        foreach ($characters as $character) {
            $this->typeCharacterIn($character, 'culture');
        }
    }

    /**
     * Will fire the keypress event on specified field.
     * This will **not** fill the field with the keystrokes
     * You need to do it manually by listening to the events
     *
     * @param $character
     * @param $field
     */
    protected function typeCharacterIn($character, $field)
    {
        $xpath = $this->getSession()->getPage()->findField($field)->getXpath();

        $this->getSession()->getDriver()->keyDown($xpath, $character);
        $this->getSession()->getDriver()->keyUp($xpath, $character);
        $this->getSession()->getDriver()->keyPress($xpath, $character);
    }



    /** TRAIT: FIELD EXTRAS *******************************************************************************************/

    /**
     * @Given /^the "(?P<field>(?:[^"]|\\")*)" field is empty$/
     */
    public function theFieldIsEmpty($field)
    {
        $node = $this->assertSession()->fieldExists($field);
        $node->setValue('');
    }

    /**
     * @Then /^the "(?P<field>(?:[^"]|\\")*)" field should be empty$/
     */
    public function theFieldShouldBeEmpty($field)
    {
        $this->assertFieldContains($field, '');
    }

    /**
     * @Then /^the "(?P<field>(?:[^"]|\\")*)" field should end by \"(?P<suffix>[^\"]*)\"$/
     */
    public function theFieldShouldEndBy($field, $suffix)
    {
        $node = $this->assertSession()->fieldExists($field);
        $actual = substr($node->getValue(), 0, -1 * strlen($suffix));
        assertEquals($suffix, $actual);
    }

    /**
     * @Then /^the "(?P<field>(?:[^"]|\\")*)" field should not end by \"(?P<suffix>[^\"]*)\"$/
     */
    public function theFieldShouldNotEndBy($field, $suffix)
    {
        $node = $this->assertSession()->fieldExists($field);
        $actual = substr($node->getValue(), 0, -1 * strlen($suffix));
        assertNotEquals($suffix, $actual);
    }

}
