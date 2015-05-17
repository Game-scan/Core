<?php namespace GameScan\Core\Request\Api\Http;

use GameScan\Core\Request\Api\ApiRequestInterface;

/**
 * Class Client
 * @package GameScan\Core\Request\Api\Http
 */
class Client implements ApiRequestInterface
{

    protected $guzzle;
    protected $headers = array();
    protected $parameters = array();
    protected $curlConfig = array();

    public function __construct()
    {
        $this->guzzle = new \GuzzleHttp\Client();
        $this->clean();
    }

    /**
     * {@inheritdoc}
     */
    public function clean()
    {
        $this->resetHeaders();
        $this->resetParameters();
    }

    private function resetHeaders()
    {
        $this->headers = array();
    }

    private function resetParameters()
    {
        $this->parameters = array();
    }

    /**
     * Http Request Timeout
     * @param int $timeout
     * @throws \Exception
     */
    public function setTimeout($timeout)
    {
        if (!is_int($timeout)) {
            throw new \Exception("Timeout must be an integer value");
        }
        $this->curlConfig[CURLOPT_TIMEOUT] = $timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $headerKey => $headerValue) {
            $this->headers[$headerKey] = $headerValue;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setParameters(array $parameters)
    {
        foreach ($parameters as $parameterKey => $parameterValue) {
            $this->parameters[$parameterKey] = $parameterValue;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get($ressourceToGrab)
    {
        $config = $this->getConfig();
        $request = $this->guzzle->createRequest("GET", $ressourceToGrab, $config);
        $response = $this->guzzle->send($request);
        $this->checkHttpStatus($response);
        return (string)$response->getBody();
    }

    /**
     * Get http request config for guzzle
     * @return array
     */
    protected function getConfig()
    {
        $config = array();
        $config['headers'] = $this->headers;
        $config['config'] = array(
            'curl' => $this->curlConfig
        );
        $config['query'] = $this->parameters;
        $config['cookies'] = true;
        return $config;
    }

    /**
     * {@inheritdoc}
     */
    protected function checkHttpStatus($response)
    {
        $statusCode = (int)$response->getStatusCode();
        if ($statusCode < 200 || $statusCode > 299) {
            throw new ApiStatusCodeException("Not successful http status code", $statusCode);
        }
    }
}
