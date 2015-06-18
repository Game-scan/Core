<?php namespace GameScan\Core\Tools;

use Dotenv\Dotenv;
use GameScan\Core\Exceptions\EnvironmentException;

class Environment
{

    private $dotEnv = null;
    private $hasLoadValues = false;

    public function __construct($path = null, $filename = ".env")
    {
        if ($path === null) {
            $path = __DIR__ . '/../../';
        }

        if (!file_exists($path . DIRECTORY_SEPARATOR . $filename)) {
            throw new EnvironmentException($path . DIRECTORY_SEPARATOR . $filename . " is not exist. Please create an environment file before using this feature");
        }

        $this->dotEnv = new Dotenv($path, $filename);
    }


    public function load()
    {
        $this->dotEnv->load();
        $this->hasLoadValues = true;
    }

    public function get($key)
    {
        if (!$this->hasLoadValues) {
            $this->load();
        }
        return getenv($key);
    }
}