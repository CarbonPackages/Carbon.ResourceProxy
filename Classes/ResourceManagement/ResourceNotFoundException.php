<?php
namespace Carbon\ResourceProxy\ResourceManagement;

use Neos\Neos\Controller\Exception;

/**
 * A "Node not found" exception
 */
class ResourceNotFoundException extends Exception
{
    /**
     * @var integer
     */
    protected $statusCode = 404;
}
