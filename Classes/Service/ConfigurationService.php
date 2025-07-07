<?php
namespace Carbon\ResourceProxy\Service;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Exception;

class ConfigurationService
{

    #[Flow\InjectConfiguration]
    protected $configuration;

    /**
     * @return array
     * @throws Exception
     */
    public function getCurrentConfiguration() : array
    {
        if (!is_array($this->configuration)) {
            throw new Exception('No resource proxy configuration not found');
        }

        $config = $this->configuration;

        if (
            !isset($config['baseUri']) &&
            !isset($config['subDirectory']) &&
            !isset($config['subdivideHashPathSegment'])
        ) {
            throw new Exception('Resource proxy configuration invalid');
        }

        return $config;
    }
}
