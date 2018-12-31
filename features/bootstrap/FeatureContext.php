<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException,
    Behat\Behat\Hook\Scope\BeforeScenarioScope,
    Behat\Behat\Hook\Scope\AfterScenarioScope,
    Facebook\WebDriver\Remote\DesiredCapabilities,
    Facebook\WebDriver\Remote\RemoteWebDriver,
    Facebook\WebDriver\WebDriverBy;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    /**
     * @var \RemoteWebDriver;
     */
    protected $webDriver;

    protected $baseUrl;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->baseUrl = "https://www.mequilibrium.com/";
    }
    
    /**
     * @When I load the homepage
     */
    public function iLoadTheHomepage()
    {
        $this->webDriver->get($this->baseUrl);
    }

    /**
     * @Then I should see :content
     */
    public function iShouldSee($content)
    {
        $pageSource = $this->webDriver->getPageSource();
        $contentFound = strpos($pageSource, $content);
        if($contentFound === false){
            throw new Exception("Cannot find content '".substr($content,0,100)."'");
        }
    }

    /**
     * @Then I should see a :privacy link
     */
    public function iShouldSeeALink($linkText)
    {
        $link = $this->webDriver->findElement(WebDriverBy::linkText($linkText));
        if(!$link){
            throw new Exception("There is no link with text '$linkText'.");
        }
        if(!$link->isDisplayed()){
            throw new Exception("linkText is not displayed.");
        }
    }

     /**
     * @Then I click the :privacy link
     */
    public function iClickTheLink($linkText)
    {
    $link = $this->webDriver->findElement(WebDriverBy::linkText($linkText));
     if(!$link){
        throw new Exception("There is no link with text '$linkText'.");
     }
     $link->click();
    }


    /**
     * @BeforeScenario
     */
    public function openWebBrowser (BeforeScenarioScope $event)
    {
        $capabilities = DesiredCapabilities::chrome();
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
    }

    /**
    * @AfterScenario
    */
    public function closeWebBrowser(AfterScenarioScope $event)
    {
        if($this->webDriver) $this->webDriver->quit();
    }   


}
