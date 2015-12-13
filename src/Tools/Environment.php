<?php namespace GameScan\Core\Tools;

use Dotenv;
use GameScan\Core\Exceptions\EnvironmentException;

class Environment
{

    private $path = null;
    private $hasLoadValues = false;

    public function __construct($path = null, $filename = ".env")
    {
        if ($path === null) {
            $path = __DIR__ . '/../../../../..';
        }

        if (!file_exists($path . DIRECTORY_SEPARATOR . $filename)) {
            throw new EnvironmentException($path . DIRECTORY_SEPARATOR . $filename . " is not exist. Please create an environment file before using this feature");
        }

        $this->path = $path;
    }


    public function load()
    {
        Dotenv::load($this->path);
        $this->hasLoadValues = true;
    }

    public function get($key, $defaultValue = false)
    {
        if (!$this->hasLoadValues) {
            $this->load();
        }
        $value = getenv($key);
        return $value !== false ? $value : $defaultValue;
    }
}
