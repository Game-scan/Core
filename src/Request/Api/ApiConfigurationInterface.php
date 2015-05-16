<?php namespace GameScan\Core\Request\Api;

interface ApiConfigurationInterface
{
    public function getParameters();

    public function getHeader();
}
