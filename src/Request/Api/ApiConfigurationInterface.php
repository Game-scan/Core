<?php namespace GameScan\Core\Request\Api;

/**
 * Configuration for an api - contains parameters and headers for request theses
 * Interface ApiConfigurationInterface
 * @package GameScan\Core\Request\Api
 */
interface ApiConfigurationInterface
{
    /**
     * Get parameters mandatory for request an api
     * @return array
     */
    public function getParameters();

    /**
     * Get headers mandatory for request an api
     * @return array
     */
    public function getHeaders();
}
