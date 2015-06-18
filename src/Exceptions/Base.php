<?php namespace GameScan\Core\Exceptions;

class Base extends \Exception
{

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        \GameScan\Core\Tools\LoggerFactory::getLogger()->error("Exception thrown : " . $this);
    }
}
