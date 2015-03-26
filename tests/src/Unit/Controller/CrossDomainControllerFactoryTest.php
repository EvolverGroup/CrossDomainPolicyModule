<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModuleTest\Unit\Controller;

use Evolver\CrossDomainPolicyModule\Controller\CrossDomainControllerFactory;
use Evolver\CrossDomainPolicyModuleTest\Util\ModuleLoader;

/**
 * Cross-Domain controller factory unit test
 *
 * @package Evolver\CrossDomainPolicyModuleTest\Unit\Controller
 */
class CrossDomainControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Module loader
     *
     * @var ModuleLoader
     */
    protected $moduleLoader;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->moduleLoader = new ModuleLoader([
            'modules' => [
                'Evolver\\CrossDomainPolicyModule'
            ],
            'module_listener_options' => [
                'check_dependencies' => true
            ]
        ]);
    }

    /**
     * Get the controller manager
     *
     * @return \Zend\Mvc\Controller\ControllerManager
     */
    public function getControllerManager()
    {
        return $this->moduleLoader->getServiceManager()->get('ControllerManager');
    }

    /**
     * Test cross-domain controller creation
     */
    public function testCreateCrossDomainController()
    {
        $factory = new CrossDomainControllerFactory();

        $this->assertInstanceOf(
            'Evolver\CrossDomainPolicyModule\Controller\CrossDomainController',
            $factory->createService($this->getControllerManager())
        );
    }
}
