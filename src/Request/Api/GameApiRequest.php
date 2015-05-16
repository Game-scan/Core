<?php namespace GameScan\Core\Request\Api;

use GameScan\Core\Request\Api\Http\Client;

class GameApiRequest
{

    protected $apiConfiguration;
    protected $apiRequest;

    public function __construct(ApiConfigurationInterface $apiConfiguration, ApiRequestInterface $apiRequest = null)
    {
        $this->apiConfiguration = $apiConfiguration;
        $this->apiRequest = $apiRequest !== null ? $apiRequest : new Client();
    }

    public function setApiConfiguration(ApiConfigurationInterface $apiConfiguration)
    {
        $this->apiConfiguration = $apiConfiguration;
    }

    public function get($ressourceToGrab)
    {
        $this->apiRequest->clean();
        $this->apiRequest->setHeaders($this->apiConfiguration->getHeader());
        $this->apiRequest->setParameters($this->apiConfiguration->getParameters());

        return $this->apiRequest->get($ressourceToGrab);
    }


}
