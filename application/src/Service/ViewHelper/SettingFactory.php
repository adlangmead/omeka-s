<?php

namespace Omeka\Service\ViewHelper;

use Omeka\View\Helper\Setting;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory for the setting view helper.
 */
class SettingFactory implements FactoryInterface
{
    /**
     * Create and return the setting view helper
     *
     * @param ServiceLocatorInterface $viewServiceLocator
     * @return Setting
     */
    public function createService(ServiceLocatorInterface $viewServiceLocator)
    {
        $serviceLocator = $viewServiceLocator->getServiceLocator();
        return new Setting($serviceLocator->get('Omeka\Settings'));
    }
}
