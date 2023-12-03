# PHPUnit Teamcity testMetadata extended support

Extended support for testMetadata in PHPUnit STDOUT.

Added Description Trait for parse @description annotation in tests

## Installation

```
composer require lirik44/phpunit-teamcity-extended
```

## Using Descripton trait

### Specify @description annotation before test function

```php
class MyTest extends PHPUnit\Framework\TestCase
{
    /**
     * @description This test check something on page
     */
    public function testSomethingOnPage()
    {
        // test something ...
    }
```
### Use DescriptionTrait in Selenium Helper:

```php
class SeleniumHelper extends TestCase
{
    protected $testHelper;
    
    public function setUp():void
    {
        $testName=$this->getName();
        $this->testHelper->setupSeleniumSession($testName);
        date_default_timezone_set( 'Europe/Moscow' );
    }
    
    use DescriptionTrait;
    
    public function tearDown():void
    {
        //If test fails get description from @description
        if ($this->hasFailed())
        {
            //Get description text
            $this->description = $this->getTestDescription();
        }
```
## Other testMetadata features

### Similar as a description you can specify different testMetadata in teadDown() section:
```php
public function tearDown():void
    {
        //Take metaData if test has failed
        if ($this->hasFailed())
        {
            //Get browser URL in the moment of test error occur
            $this->browserLink = $this->webDriver->getCurrentURL();
            //Get browser screenshot in the moment of test error occur
            $this->screenshotErr = $this->testHelper->getErrorScreenshot($testName);
            //Get php_errors.log after test fails
            $this->errLog = $this->testHelper->getPhpErrorLog($testName);
            //Get mono.log after test fails
            $this->monoLog = $this->testHelper->getMonoLog($testName);
            }
        }
```
### Also it is possible to get any information into setUp() section and publish that as a buildTag:
```php
public function setUp():void
    {
        $testName=$this->getName();
        $this->testHelper->setupSeleniumSession($testName);
        date_default_timezone_set( 'Europe/Moscow' );
        //Get current application git branch
        $this->buildTag = $this->getUsedBranch();
    }
```