<?php namespace GameScan\Core\Request\Api;

interface ApiRequestInterface
{
    public function clean();

    public function setHeaders(array $headers);

    public function setParameters(array $parameters);

    public function get($ressourceToGrab);
}
