<?php

use \Mockery;
use \GameScan\Core\Request\Api;

class GameApiRequestTest extends PHPUnit_Framework_TestCase
{
    
    public function provideStatusCodeOk()
    {
        return array(
            array('200')
        );
    }

    public function provideStatusCodeKo()
    {
        return array(
            array('404'),
            array('503'),
        );
    }

    public function provideRequestAdditionnalData()
    {
        return array(
            array(array(), array()),
            array(array("fields" => "a"), array()),
            array(array() , array("keyHeader" => "b")),
            array(array("fields" => "a") , array("keyHeader" => "b")),
        );
    }


    /**
     * @dataProvider provideStatusCodeOk
     */
    public function testStatusCodeOk($statusCodeExpected)
    {
        $testUrl = "http://httpbin.org/status/" . $statusCodeExpected;
        $apiConfiguration = Mockery::mock('GameScan\Core\Request\Api\ApiConfigurationInterface', array("getParameters" => array(), "getHeaders" => array()));
        $gameApi = new Api\GameApiRequest($apiConfiguration);
        $gameApi->get($testUrl);
    }

    /**
     * @dataProvider provideStatusCodeKo
     * @expectedException Exception
     */
    public function testStatusCodeKo($statusCodeExpected)
    {
        $testUrl = "http://httpbin.org/status/" . $statusCodeExpected;
        $apiConfiguration = Mockery::mock('GameScan\Core\Request\Api\ApiConfigurationInterface', array("getParameters" => array(), "getHeaders" => array()));

        $gameApi = new Api\GameApiRequest($apiConfiguration);
        $gameApi->get($testUrl);
    }

    /**
     * @dataProvider provideRequestAdditionnalData
     */
    public function testGetRequestOk($parameters, $headers)
    {
        $url = "http://httpbin.org/get";
        $apiConfiguration = Mockery::mock('GameScan\Core\Request\Api\ApiConfigurationInterface', array("getParameters" => $parameters, "getHeaders" => $headers));

        $gameApi = new Api\GameApiRequest($apiConfiguration);
        $content = $gameApi->get($url);
        $content = json_decode($content);
        $this->assertParametersFromGetRequest($parameters, $content);
        $this->assertHeadersFromGetRequest($headers, $content);

    }


    protected function assertParametersFromGetRequest($parameters, $content)
    {
        foreach ($parameters as $key => $value) {
            $this->assertTrue(isset($content->args->$key));
            $this->assertEquals($content->args->$key, $value);
        }
    }

    protected function assertHeadersFromGetRequest($headers, $content)
    {
        foreach ($headers as $key => $value) {
            $key = ucfirst(strtolower($key));
            $this->assertTrue(isset($content->headers->$key));
            $this->assertEquals($content->headers->$key, $value);
        }
    }
}
