<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

return [
    'router' => [
        'routes' => [
            'crossdomain' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/crossdomain.xml',
                    'defaults' => [
                        'controller' => 'Evolver\\CrossDomainPolicyModule\\CrossDomainController'
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            'Evolver\\CrossDomainPolicyModule\\CrossDomainController' => 'Evolver\\CrossDomainPolicyModule\\Controller\\CrossDomainControllerFactory'
        ]
    ],
    'service_manager' => [
        'factories' => [
            'Evolver\\CrossDomainPolicyModule\\CrossDomainService' => "Evolver\\CrossDomainPolicyModule\\Service\\CrossDomainServiceFactory"
        ]
    ]
];
