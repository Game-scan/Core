<?php namespace GameScan\Core\Tools;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class Log
{
    const LOG_NAME = "GAME-SCAN";
    private $log = null;
    private $handlers = array();
    private $prefix = null;
    private $formatter = null;
    private $outputFormat = "[%datetime%] [%channel%] [%level_name%] %message% %context% %extra%\n";
    private $dateFormat =  "Y-m-d H:i:s";
    private $path =  "/tmp/gameScan.log";
    private $logLevel = 200;
    private $processor = null;
    private $availablesConfigs = [
        "outputFormat",
        "dateFormat",
        "path",
        "logLevel"
    ];


    public function __construct(\Monolog\Handler\AbstractHandler $handler = null, $formatter = null, $processor = null, array $config = array())
    {
        $this->loadConfig($config);
        $this->initializeFormatter($formatter);
        $this->initializeHandler($handler);
        $this->initializeProcessor($processor);
        $this->initializeLoger();
    }

    private function loadConfig($config)
    {
        foreach ($this->availablesConfigs as $configKey) {
            if (isset($config[$configKey])) {
                $this->$configKey = $config[$configKey];
            }
        }
    }

    private function initializeFormatter($formatter)
    {
        $this->formatter = $formatter === null ? new LineFormatter($this->outputFormat, $this->dateFormat) : $formatter ;
    }
    private function initializeHandler($handler)
    {
        $this->handlers[] = $handler === null ? new StreamHandler($this->path, $this->logLevel) : $handler ;
        $handler = end($this->handlers);
        $handler->setFormatter($this->formatter);
    }

    private function initializeProcessor($processor)
    {
        $this->processor = $processor === null ? new \Monolog\Processor\WebProcessor() : $processor ;
    }

    private function initializeLoger()
    {
        $this->log = new Logger(static::LOG_NAME);
        $this->log->pushHandler(end($this->handlers));
        $this->log->pushProcessor($this->processor);
    }

    public function addHandler(\Monolog\Handler\AbstractHandler $handler)
    {
        $this->initializeHandler($handler);
        $this->log->pushHandler($handler);
    }


    public function setHandler(\Monolog\Handler\AbstractHandler $handler)
    {
        $this->resetHandlers();
        $this->addHandler($handler);
    }
    private function resetHandlers()
    {
        array_map(
            function () {
                return $this->log->popHandler();
            },
            $this->log->getHandlers()
        );

        $this->handlers = array();
    }


    public function info($message)
    {
        $this->log->addInfo(
            $this->formatMessage($message)
        );
    }


    public function debug($message)
    {
        $this->log->addDebug(
            $this->formatMessage($message)
        );
    }


    public function warning($message)
    {
        $this->log->addWarning(
            $this->formatMessage($message)
        );
    }


    public function error($message)
    {
        $this->log->addError(
            $this->formatMessage($message)
        );
    }


    public function critical($message)
    {
        $this->log->addCritical(
            $this->formatMessage($message)
        );
    }


    public function emergency($message)
    {
        $this->log->addEmergency(
            $this->formatMessage($message)
        );
    }
    
    private function formatMessage($message)
    {
        return  $this->prefix . $message;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }
}
