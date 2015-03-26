<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModule\Service;

use Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

/**
 * Cross-Domain service factory
 *
 * @package Evolver\CrossDomainPolicyModule\Service
 */
class CrossDomainServiceFactory implements FactoryInterface
{
    /**
     * Create cross-domain service
     *
     * @param ServiceLocatorInterface $serviceManager
     *
     * @return CrossDomainService
     */
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $policy = new CrossDomainPolicy();

        /** @var array $config */
        $config = $serviceManager->get('Config');
        if (isset($config['crossdomain']) && isset($config['crossdomain']['policy'])) {
            $policy->setFromArray($config['crossdomain']['policy']);
        }

        $service = new CrossDomainService();
        return $service
            ->setCrossDomainPolicy($policy);
    }
}
