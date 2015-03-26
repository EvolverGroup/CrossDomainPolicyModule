<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy\AllowAccessIdentity\Signatory;

use Zend\Stdlib\AbstractOptions;
use Zend\Stdlib\Exception;

/**
 * Certificate options
 *
 * @package Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy\AllowAccessIdentity\Signatory
 */
class Certificate extends AbstractOptions
{
    /**
     * Fingerprint pattern
     */
    const FINGERPRINT_PATTERN = '/^([0-9a-fA-F][: ]?){40}$/';

    /**
     * SHA-1 algorithm
     */
    const ALGORITHM_SHA1 = 'sha-1';

    /**
     * Fingerprint
     *
     * @var null|string
     */
    protected $fingerprint;

    /**
     * Algorithm
     *
     * @var null|string
     */
    protected $algorithm;

    /**
     * Get fingerprint
     *
     * @return null|string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * Set fingerprint
     *
     * @param string $fingerprint
     *
     * @throws Exception\InvalidArgumentException
     *
     * @return $this
     */
    public function setFingerprint($fingerprint)
    {
        if (preg_match(self::FINGERPRINT_PATTERN, $fingerprint) < 1) {
            throw new Exception\InvalidArgumentException('Invalid fingerprint');
        }
        $this->fingerprint = $fingerprint;
        return $this;
    }

    /**
     * Get algorithm
     *
     * @return null|string
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Set algorithm
     *
     * @param string $algorithm
     *
     * @throws Exception\InvalidArgumentException
     *
     * @return $this
     */
    public function setAlgorithm($algorithm)
    {
        $algorithm = strtolower($algorithm);
        if (self::ALGORITHM_SHA1 !== $algorithm) {
            throw new Exception\InvalidArgumentException('Invalid algorithm');
        }
        $this->algorithm = $algorithm;
        return $this;
    }
}
