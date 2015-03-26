<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModuleTest;

use Evolver\CrossDomainPolicyModuleTest\Util\ModuleLoader;

/**
 * Module integration test
 *
 * @package Evolver\CrossDomainPolicyModuleTest
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
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
     * Get the module manager
     *
     * @return \Zend\ModuleManager\ModuleManager
     */
    public function getModuleManager()
    {
        return $this->moduleLoader->getServiceManager()->get('ModuleManager');
    }

    /**
     * Test the module availability
     */
    public function testModuleAvailability()
    {
        $moduleManager = $this->getModuleManager();

        $this->assertNotNull($moduleManager->getModule('Evolver\\CrossDomainPolicyModule'));
        $this->assertInstanceOf(
            'Evolver\CrossDomainPolicyModule\Module',
            $moduleManager->getModule('Evolver\\CrossDomainPolicyModule')
        );
    }
}
