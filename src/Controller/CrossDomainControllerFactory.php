<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModule\Controller;

use Zend\Http\Header\ContentType;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

/**
 * Cross-Domain controller factory
 *
 * @package Evolver\CrossDomainPolicyModule\Controller
 */
class CrossDomainControllerFactory implements FactoryInterface
{
    /**
     * Create cross-domain controller
     *
     * @param ServiceLocatorInterface $controllerManager
     *
     * @return CrossDomainController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var \Zend\Mvc\Controller\ControllerManager $controllerManager */
        $serviceManager = $controllerManager->getServiceLocator();

        /** @var \Evolver\CrossDomainPolicyModule\Service\CrossDomainService $crossDomainService */
        $crossDomainService = $serviceManager->get('Evolver\\CrossDomainPolicyModule\\CrossDomainService');

        /** @var array $config */
        $config = $serviceManager->get('Config');
        if (isset($config['crossdomain']) && isset($config['crossdomain']['content_type'])) {
            $contentType = new ContentType($config['crossdomain']['content_type']);
        } else {
            $contentType = new ContentType('text/x-cross-domain-policy');
        }

        $controller = new CrossDomainController();
        return $controller
            ->setCrossDomainService($crossDomainService)
            ->setContentType($contentType);
    }
}
