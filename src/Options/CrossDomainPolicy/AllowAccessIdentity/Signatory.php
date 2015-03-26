<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy\AllowAccessIdentity;

use Zend\Stdlib\AbstractOptions;

/**
 * Signatory options
 *
 * @package Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy\AllowAccessIdentity
 */
class Signatory extends AbstractOptions
{
    /**
     * Certificate
     *
     * @var null|Signatory\Certificate
     */
    protected $certificate;

    /**
     * Get certificate
     *
     * @return null|Signatory\Certificate
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * Set certificate
     *
     * @param array|\Traversable|Signatory\Certificate $certificate
     *
     * @return $this
     */
    public function setCertificate($certificate)
    {
        if (!$certificate instanceof Signatory\Certificate) {
            $certificate = new Signatory\Certificate($certificate);
        }
        $this->certificate = $certificate;
        return $this;
    }
}
