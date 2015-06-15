<?php

use GameScan\Core\Tools\Environment;

class EnvironmentTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException GameScan\Core\Exceptions\EnvironmentException
     */
    public function testInvalidDotEnvFile()
    {
        new Environment(uniqid(), uniqid());
    }
}
