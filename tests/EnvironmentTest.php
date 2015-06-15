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

    public function testValidDotEnvFile()
    {
        $hasCreateDotEnvFile = false;
        $pathToDotEnvFile = __DIR__ . '/../../' . DIRECTORY_SEPARATOR . ".env";
        if (!file_exists($pathToDotEnvFile)) {
            touch($pathToDotEnvFile);
            $hasCreateDotEnvFile = true;
        }
        new Environment();

        if ($hasCreateDotEnvFile) {
            unlink($pathToDotEnvFile);
        }
    }

    public function testLoadIncorrectKey()
    {
        $hasCreateDotEnvFile = false;
        $pathToDotEnvFile = __DIR__ . '/../../' . DIRECTORY_SEPARATOR . ".env";
        if (!file_exists($pathToDotEnvFile)) {
            touch($pathToDotEnvFile);
            $hasCreateDotEnvFile = true;
        }
        $environmentServiceProvider = new Environment();

        $this->assertFalse($environmentServiceProvider->get(uniqid()));


        if ($hasCreateDotEnvFile) {
            unlink($pathToDotEnvFile);
        }
    }
}
