<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy;

use Zend\Stdlib\AbstractOptions;

/**
 * Allow access identity options
 *
 * @package Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy
 */
class AllowAccessIdentity extends AbstractOptions
{
    /**
     * Signatory
     *
     * @var null|AllowAccessIdentity\Signatory
     */
    protected $signatory;

    /**
     * Get signatory
     *
     * @return null|AllowAccessIdentity\Signatory
     */
    public function getSignatory()
    {
        return $this->signatory;
    }

    /**
     * Set signatory
     *
     * @param array|\Traversable|AllowAccessIdentity\Signatory $signatory
     *
     * @return $this
     */
    public function setSignatory($signatory)
    {
        if (!$signatory instanceof AllowAccessIdentity\Signatory) {
            $signatory = new AllowAccessIdentity\Signatory($signatory);
        }
        $this->signatory = $signatory;
        return $this;
    }
}
