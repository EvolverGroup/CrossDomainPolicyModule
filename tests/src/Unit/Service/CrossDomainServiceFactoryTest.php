<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModuleTest\Unit\Controller;

use Evolver\CrossDomainPolicyModule\Service\CrossDomainServiceFactory;

/**
 * Cross-Domain service factory unit test
 *
 * @package Evolver\CrossDomainPolicyModuleTest\Unit\Service
 */
class CrossDomainServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get the service manager mock
     *
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManagerMock()
    {
        $serviceManagerMock = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->setMethods(['get'])
            ->getMock();

        $serviceManagerMock
            ->expects($this->once())
            ->method('get')
            ->with('Config')
            ->will($this->returnValue([
                'crossdomain' => [
                    'policy' => []
                ]
            ]));

        return $serviceManagerMock;
    }

    /**
     * Test cross-domain service creation
     */
    public function testCreateCrossDomainController()
    {
        $factory = new CrossDomainServiceFactory();

        $this->assertInstanceOf(
            'Evolver\CrossDomainPolicyModule\Service\CrossDomainService',
            $factory->createService($this->getServiceManagerMock())
        );
    }
}
