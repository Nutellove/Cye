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

Get composer, install :

    curl -s https://getcomposer.org/installer | php
    php composer.phar install

Also see PITFALLS below.

We're still using the awful `composer.json` instead of `composer.yml`.
Gotta make or find a small script someday that wraps composer...


## TEST

You'll need [selenium](http://docs.seleniumhq.org/download/).

Start the php built-in web server :

    php -S localhost:7878 -t web web/route.php
    
We use `route.php` to simulate the `mod_rewrite` Apache directive in
`.htaccess`. You can skip the built-in web server if you use Apache,
but remember to change the `base_url` directive in `behat.yml`.

Optionally, you can follow [Selenium setup](http://docs.behat.org/cookbook/behat_and_mink.html#test-in-browser-selenium2-session).

Start the selenium server in another console :

    java -jar selenium.jar

Then, simply run in yet another console :

    bin/behat


## PITFALLS

### Typing

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

Extending `Selenium2Driver` is straightforward,
but making `Mink` use my custom driver... o.O

Years later, there's still no `type()` method in the driver.


### Cache

Finally, make sure the `cache/` folder is writable.

    sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx cache
    sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx cache