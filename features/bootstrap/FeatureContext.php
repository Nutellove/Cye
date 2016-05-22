<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;

// MinkContext has no `assertEquals` method. This feels wrong. 
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';


/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     */
    public function __construct()
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

    
    // STEPS ///////////////////////////////////////////////////////////////////

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
        $this->execJs("document.getElementById('expected_answer').innerHTML = '{$value}';");
    }

    /**
     * @Given /^I wait for (\d+) seconds?$/
     */
    public function iWaitForSeconds($how_many)
    {
        $this->getSession()->wait($how_many * 1000);
    }

    
    // TRAIT: TYPING ///////////////////////////////////////////////////////////

    /**
     * Needs the Selenium2 Driver (works with Syn.js)
     *
     * @When /^I type \"([^\"]+)\" in the "(?P<field>(?:[^"]|\\")+)" field$/
     */
    public function iTypeInTheField($string, $field)
    {
        $xpath = $this->getSession()->getPage()->findField($field)->getXpath();
        // focus on the field (this will load needed Syn with protected withSyn)
        $this->getSession()->getDriver()->focus($xpath);
        // type (see README > PITFALLS)
        $this->getSession()->getDriver()->type($xpath, $string);
        // wait a bit, typing is asynchronous it seems
        $this->getSession()->wait(1000);
    }


    // TRAIT: FIELD EXTRAS /////////////////////////////////////////////////////

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


    // UNUSED //////////////////////////////////////////////////////////////////

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

}
