<?php
namespace Omeka\Service;

use Omeka\Site\Navigation\Link\Manager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NavigationLinkManagerFactory implements FactoryInterface
{
    /**
     * Create the navigation link manager service.
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return Manager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        if (!isset($config['navigation_links'])) {
            throw new Exception\ConfigException('Missing navigation link configuration');
        }
        return new Manager(new Config($config['navigation_links']));
    }
}
