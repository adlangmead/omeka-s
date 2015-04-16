<?php
namespace Omeka\File\Store;

use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Interface for a store of files.
 *
 * File stores abstract over simple file operations.
 */
interface StoreInterface extends ServiceLocatorAwareInterface
{
    /**
     * Store a file.
     *
     * @param string $source Local path to the file to store
     * @param string $storagePath Storage path to store at
     */
    public function put($source, $storagePath);

    /**
     * Delete a stored file.
     *
     * @param string $storagePath Storage path for file
     */
    public function delete($storagePath);

    /**
     * Get the URI for a stored file.
     *
     * @param string $storagePath Storage path for file
     */
    public function getUri($storagePath);
}