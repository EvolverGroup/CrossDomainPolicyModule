<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModuleTest\Util;

use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * Module loader test util
 *
 * @package Evolver\CrossDomainPolicyModuleTest\Util
 */
class ModuleLoader
{
    /**
     * Application config
     *
     * @var array
     */
    protected $applicationConfig;

    /**
     * Service manager
     *
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * Create the module loader
     *
     * @param array $applicationConfig
     */
    public function __construct(array $applicationConfig = array())
    {
        if (isset($applicationConfig['module_listener_options']['config_cache_enabled'])) {
            $applicationConfig['module_listener_options']['config_cache_enabled'] = false;
        }

        $this->applicationConfig = $applicationConfig;
    }

    /**
     * Get the service manager
     *
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        if (!$this->serviceManager instanceof ServiceManager) {
            $configuration = [];
            if (isset($this->applicationConfig['service_manager'])) {
                $configuration = $this->applicationConfig['service_manager'];
            }

            $this->serviceManager = new ServiceManager(new ServiceManagerConfig($configuration));
            $this->serviceManager->setService('ApplicationConfig', $this->applicationConfig);
            $this->serviceManager->get('ModuleManager')->loadModules();
        }

        return $this->serviceManager;
    }
}
