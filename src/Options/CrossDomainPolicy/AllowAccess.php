<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy;

use Zend\Stdlib\AbstractOptions;
use Zend\Stdlib\Exception;

/**
 * Allow access options
 *
 * @package Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy
 */
class AllowAccess extends AbstractOptions
{
    /**
     * Domain pattern
     */
    const DOMAIN_PATTERN = '/^\*|(\*?[A-Za-z0-9\-\.]+)$/';

    /**
     * Port pattern
     */
    const PORT_PATTERN = '/^\*|([0-9]+(-[0-9]+)?)$/';

    /**
     * @var null|string
     */
    protected $domain;

    /**
     * @var string[]
     */
    protected $ports;

    /**
     * @var null|bool
     */
    protected $secure;

    /**
     * Get domain
     *
     * @return null|string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set domain
     *
     * @param string $domain
     *
     * @throws Exception\InvalidArgumentException
     *
     * @return $this
     */
    public function setDomain($domain)
    {
        if (preg_match(self::DOMAIN_PATTERN, $domain) < 1) {
            throw new Exception\InvalidArgumentException('Invalid domain');
        }
        $this->domain = $domain;
        return $this;
    }

    /**
     * Get ports
     *
     * @return string[]
     */
    public function getPorts()
    {
        if (null === $this->ports) {
            return [];
        }
        return $this->ports;
    }

    /**
     * Set ports
     *
     * @param string|string[] $ports
     *
     * @throws Exception\InvalidArgumentException
     *
     * @return $this
     */
    public function setPorts($ports)
    {
        if (!is_array($ports)) {
            $ports = explode(',', $ports);
        }
        foreach ($ports as $port) {
            if (preg_match(self::PORT_PATTERN, $port) < 1) {
                throw new Exception\InvalidArgumentException('Invalid port');
            }
        }
        $this->ports = $ports;
        return $this;
    }

    /**
     * Get $secure
     *
     * @return null|bool
     */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * Set $secure
     *
     * @param null|bool $secure
     *
     * @return $this
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;
        return $this;
    }
}
