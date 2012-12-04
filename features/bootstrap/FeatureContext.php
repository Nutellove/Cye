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





    /**
     * @Given /^I am focused on the (.+) input$/
     */
    public function iAmFocusedOnTheInput($name)
    {
        throw new PendingException();
    }

    /**
     * @Given /^the expected culture input is \"([^\"]*)\"$/
     */
    public function theExpectedCultureInputIs($value)
    {
        throw new PendingException();
    }

    /**
     * @Given /^the (.+) input is empty$/
     */
    public function theInputIsEmpty($name)
    {
        throw new PendingException();
    }

    /**
     * @Then /^the (.+) input should be empty$/
     */
    public function theInputShouldBeEmpty($name)
    {
        throw new PendingException();
    }

    /**
     * @Then /^the (.+) input should not end by \"([^\"]*)\"$/
     */
    public function theInputShouldNotEndBy($name, $suffix)
    {
        throw new PendingException();
    }

    /**
     * @Then /^the (.+) input should hold \"([^\"]*)\"$/
     */
    public function theInputShouldHold($name, $value)
    {
        throw new PendingException(); // use parent
    }

    /**
     * @When /^I type \"([^\"]*)\"$/
     */
    public function iType($string)
    {
        throw new PendingException();
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

}
