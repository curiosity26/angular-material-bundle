<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 4/2/17
 * Time: 12:45 PM
 */

class TestControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    protected static $class = '\Curiosity26\AngularMaterialBundle\Tests\AppKernel';

    public function testTextAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/test/text');

        $this->assertEquals('200', $client->getResponse()->getStatusCode());

        $container = $crawler->filter("form md-input-container");

        $this->assertNotEmpty($container);

        $label = $container->filter('label');

        $this->assertEquals('Test', $label->text());

        $input = $container->filter('input');

        $this->assertEquals(['text'], $input->extract(['type']));
    }

    public function testRadioAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/test/radio');

        $this->assertEquals('200', $client->getResponse()->getStatusCode());

        $input = $crawler->filter("form md-radio-group md-radio-button");
        $this->assertNotEmpty($input);
        $this->assertEquals(['test1'], $input->eq(0)->extract(['value']));
        $this->assertEquals('Test 1', trim($input->eq(0)->text()));
        $this->assertEquals(['test2'], $input->eq(1)->extract(['value']));
        $this->assertEquals('Test 2', trim($input->eq(1)->text()));
    }

    public function testCheckboxAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/test/checkbox');

        $this->assertEquals('200', $client->getResponse()->getStatusCode());

        $input = $crawler->filter("form md-checkbox-group md-checkbox");
        $this->assertNotEmpty($input);
        $this->assertEquals(['test1'], $input->eq(0)->extract(['ng-yes-value']));
        $this->assertEquals('Test 1', trim($input->eq(0)->text()));
        $this->assertEquals(['test2'], $input->eq(1)->extract(['ng-yes-value']));
        $this->assertEquals('Test 2', trim($input->eq(1)->text()));
    }

    public function testSelectAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/test/select');

        $this->assertEquals('200', $client->getResponse()->getStatusCode());

        $input = $crawler->filter("form md-select md-option");
        $this->assertNotEmpty($input);
        $this->assertEquals(['test1'], $input->eq(0)->extract(['value']));
        $this->assertEquals('Test 1', trim($input->eq(0)->text()));
        $this->assertEquals(['test2'], $input->eq(1)->extract(['value']));
        $this->assertEquals('Test 2', trim($input->eq(1)->text()));
    }

}
