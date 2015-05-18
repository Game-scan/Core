<?php namespace GameScan\Core\Request\Api;

/**
 * Interface for request an api
 * Interface ApiRequestInterface
 * @package GameScan\Core\Request\Api
 */
interface ApiRequestInterface
{
    /**
     * Reset headers and parameters for http request
     * @return void
     */
    public function clean();

    /**
     * Set headers for requests
     * @param array $headers
     * @return mixed
     */
    public function setHeaders(array $headers);

    /**
     * Set parameters for requests
     * @param array $parameters
     * @return mixed
     */
    public function setParameters(array $parameters);

    /**
     * Get call on a specific url
     * @param string $ressourceToGrab
     * @param array|null $parameters
     * @return string Body content
     * @throws ApiStatusCodeException
     */
    public function get($ressourceToGrab, array $parameters = null);
}
