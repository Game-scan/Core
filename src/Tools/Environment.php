<?php namespace GameScan\Core\Tools;

use Dotenv\Dotenv;

class Environment
{

    private $dotEnv = null;
    private $hasLoadValues = false;

    public function __construct()
    {
        $this->dotEnv = new Dotenv(__DIR__.'/../../');
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
