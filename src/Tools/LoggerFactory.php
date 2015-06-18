<?php namespace GameScan\Core\Tools;

class LoggerFactory
{
    public static function getLogger()
    {
        return new Log();
    }
}
