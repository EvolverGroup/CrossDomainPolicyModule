<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModuleTest\Integration\Controller;

/**
 * Cross-Domain controller integration test
 *
 * @package Evolver\CrossDomainPolicyModuleTest\Integration\Controller
 */
class CrossDomainControllerTest extends AbstractControllerTestCase
{
    /**
     * Get the application config
     *
     * @return array
     */
    public function getApplicationConfig()
    {
        return [
            'modules' => [
                'Evolver\\CrossDomainPolicyModule'
            ],
            'module_listener_options' => [
                'check_dependencies' => true
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $serviceManager = $this->getServiceManager();
        $serviceManager->setAllowOverride(true);
        $config = $serviceManager->get('Config');
        $config['crossdomain'] = [
            'content_type' => 'text/x-cross-domain-policy',
            'policy' => [
                'site_control' => 'master-only',
                'allow_access' => [
                    [
                        'domain' => '*.example.com'
                    ], [
                        'domain' => 'www.example.com',
                        'ports' => 80,
                        'secure' => false
                    ]
                ],
                'allow_headers' => [
                    [
                        'domain' => '*.adobe.com',
                        'headers' => 'SOAPAction'
                    ]
                ],
                'allow_access_identity' => [
                    [
                        'signatory' => [
                            'certificate' => [
                                'fingerprint' => '01:23:45:67:89:ab:cd:ef:01:23:45:67:89:ab:cd:ef:01:23:45:67',
                                'algorithm' => 'sha-1'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $serviceManager->setService('Config', $config);
    }

    /**
     * Test cross-domain controller response status
     */
    public function testCrossDomainControllerResponseStatus()
    {
        $this->dispatch('/crossdomain.xml');

        $this->assertEquals(200, $this->getResponse()->getStatusCode());
    }

    /**
     * Test cross-domain controller response headers
     */
    public function testCrossDomainControllerResponseHeaders()
    {
        $this->dispatch('/crossdomain.xml');
        $headers = $this->getResponse()->getHeaders();

        $this->assertTrue($headers->has('Content-Type'));
        $this->assertEquals('text/x-cross-domain-policy', $headers->get('Content-Type')->getFieldValue());
    }

    /**
     * Test cross-domain controller response headers
     */
    public function testCrossDomainControllerResponseContent()
    {
        $this->dispatch('/crossdomain.xml');
        $content = $this->getResponse()->getContent();

        $this->assertXmlStringEqualsXmlString(file_get_contents('tests/resources/crossdomain.xml'), $content);
    }
}
