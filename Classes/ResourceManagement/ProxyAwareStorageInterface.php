<?php
namespace Carbon\ResourceProxy\ResourceManagement;

use Neos\Flow\ResourceManagement\ResourceMetaDataInterface;

interface ProxyAwareStorageInterface
{
    public function resourceIsPresentInStorage(ResourceMetaDataInterface $resource): bool;
}
