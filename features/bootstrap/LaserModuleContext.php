<?php

use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Driver\Selenium2Driver;
use \SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class LaserModuleContext extends PageObjectContext
{
    public function __construct(array $parameters)
    {
    }

    /**
     * @Then /^I create a Laser Event$/
     */
    public function iCreateALaserEvent()
    {
        /**
         * @var laser $laserModulePage
         */
        $laserPage = $this->getPage('laserModule');
        $laserPage->createLaserEvent();
    }
}
