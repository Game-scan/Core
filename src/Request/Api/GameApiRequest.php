<?php namespace GameScan\Core\Request\Api;

use GameScan\Core\Request\Api\Http\Client;

/**
 * Class GameApiRequest
 *
 * Used for request api of each games
 * @package GameScan\Core\Request\Api
 */
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

    /**
     * Request a ressource of an api with the get http method
     * @param $ressourceToGrab
     * @return string
     */
    public function get($ressourceToGrab)
    {
        $this->apiRequest->clean();
        $this->apiRequest->setHeaders($this->apiConfiguration->getHeaders());
        $this->apiRequest->setParameters($this->apiConfiguration->getParameters());

        return $this->apiRequest->get($ressourceToGrab);
    }
}
