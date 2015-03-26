<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModuleTest\Unit;

use Evolver\CrossDomainPolicyModule\Module;

/**
 * Module unit test
 *
 * @package Evolver\CrossDomainPolicyModuleTest
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the module config
     */
    public function testModuleConfig()
    {
        $config = require __DIR__ . '/../../../config/module.config.php';
        $module = new Module();

        $this->assertEquals($config, $module->getConfig());
    }
}
