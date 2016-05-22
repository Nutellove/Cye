Cye
===

These are the sources of a party computer magic trick, which I wrote to
experiment Behavior-Driven Development with integration tests written
in Gherkin.

There are no unit-tests. We don't need them in this project.


## USE

1. `features/` contains the documentation in the form of scenarios.
2. `web/index.php` contains most of the PHP glue.
3. `view/` contains the twig templates.


## INSTALL

Get composer, install, and make sure the `cache/` folder is writable.

    curl -s https://getcomposer.org/installer | php
    php composer.phar install

    sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx cache
    sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx cache

Also see PITFALLS below.

We're still using the awful `composer.json` instead of `composer.yml`.
Gotta make or find a small script someday that wraps composer...




## TEST

Create your `http://cye.local` that points to `web`, or change the `base_url` in `behat.yml`.

Follow [Selenium setup](http://docs.behat.org/cookbook/behat_and_mink.html#test-in-browser-selenium2-session).

Start the selenium server :

    java -jar selenium.jar

Then, simply run :

    bin/behat


## PITFALLS

Monkey added to `vendor/behat/mink-selenium2-driver/src/Behat/Mink/Driver/Selenium2Driver.php` :

    /**
     * Type the $string
     * Will fire the appropriate keyboard events keyDown/keyPress/keyUp
     *
     * @param string $xpath
     * @param string $string
     */
    public function type($xpath, $string)
    {
        $script = "Syn.type(\"{$string}\", {{ELEMENT}})";
        $this->withSyn()->executeJsOnXpath($xpath, $script);
    }

FIXME : extending `Selenium2Driver` is straightforward,
but making `Mink` use my custom driver... o.O