<?php
namespace Carbon\ResourceProxy\ResourceManagement;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Mvc\Routing\UriBuilder;
use Neos\Flow\ResourceManagement\ResourceManager;
use Neos\Flow\ResourceManagement\Target\FileSystemTarget;
use Carbon\ResourceProxy\Service\ConfigurationService;

class ProxyAwareFileSystemTarget extends FileSystemTarget implements ProxyAwareTargetInterface
{
    use ProxyAwareTargetTrait;

    #[Flow\Inject]
    protected Bootstrap $bootstrap;

    #[Flow\Inject]
    protected UriBuilder $uriBuilder;

    #[Flow\Inject]
    protected ResourceManager $resourceManager;

    #[Flow\Inject]
    protected ConfigurationService $configurationService;
}
