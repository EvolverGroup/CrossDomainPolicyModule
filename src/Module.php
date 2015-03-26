<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModule;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Cross-Domain policy module
 *
 * @package Evolver\CrossDomainPolicyModule
 */
class Module implements ConfigProviderInterface
{
    /**
     * Returns configuration to merge with application configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}
