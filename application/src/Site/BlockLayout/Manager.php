<?php
namespace Omeka\Site\BlockLayout;

use Omeka\Api\Exception;
use Omeka\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

class Manager extends AbstractPluginManager
{
    /**
     * Do not replace strings during canonicalization.
     *
     * This prevents distinct yet similarly named block layouts from referencing
     * the same handler instance.
     *
     * {@inheritDoc}
     */
    protected $canonicalNamesReplacements = [];

    /**
     * {@inheritDoc}
     */
    public function get($name, $options = [], $usePeeringServiceManagers = true) {
        try {
            $instance = parent::get($name, $options, $usePeeringServiceManagers);
        } catch (ServiceNotFoundException $e) {
            $instance = new Fallback($name);
        }
        return $instance;
    }

    /**
     * {@inheritDoc}
     */
    public function validatePlugin($plugin)
    {
        if (!is_subclass_of($plugin, 'Omeka\Site\BlockLayout\BlockLayoutInterface')) {
            throw new Exception\InvalidAdapterException(sprintf(
                'The block layout class "%s" does not implement Omeka\BlockLayout\BlockLayoutInterface.',
                get_class($plugin)
            ));
        }
    }
}
