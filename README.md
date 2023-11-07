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
        $nameOfTest=$this->getName();
        $this->testHelper->setupSeleniumSession($nameOfTest);
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
## Other options

### Similar as a description you can specify different testMetadata in teadDown() section:
```php
public function tearDown():void
    {
        //Take metaData if test has failed
        if ($this->hasFailed())
        {
            //Get browser URL in the moment of test error occur
            $this->errorLink = $this->webDriver->getCurrentURL();
            //Get browser screenshot in the moment of test error occur
            $this->errorScreen = $this->testHelper->getErrorScreenshot($nameOfTest);
            //Get php_errors.log after test fails
            $this->phpErrorLog = $this->testHelper->getPhpErrorLog($nameOfTest);
            //Get mono.log after test fails
            $this->monoLog = $this->testHelper->getMonoLog($nameOfTest);
            }
        }
```
### Also it is possible to get any information into setUp() section and publish that as a buildTag:
```php
public function setUp():void
    {
        $nameOfTest=$this->getName();
        $this->testHelper->setupSeleniumSession($nameOfTest);
        date_default_timezone_set( 'Europe/Moscow' );
        //Get current application git branch
        $this->appBranch = $this->getUsedBranch();
    }
```