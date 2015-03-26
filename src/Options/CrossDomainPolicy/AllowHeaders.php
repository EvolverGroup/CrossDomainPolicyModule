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
 * Allow headers options
 *
 * @package Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy
 */
class AllowHeaders extends AbstractOptions
{
    /**
     * Domain pattern
     */
    const DOMAIN_PATTERN = '/^\*|(\*?[A-Za-z0-9\-\.]+)$/';

    /**
     * Header pattern
     */
    const HEADER_PATTERN = '/^\*|([\x21-\x29\x2b\x2d-\x39\x3b-\x7e]+\*?)$/';

    /**
     * @var null|string
     */
    protected $domain;

    /**
     * @var string[]
     */
    protected $headers;

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
     * Get headers
     *
     * @return string[]
     */
    public function getHeaders()
    {
        if (null === $this->headers) {
            return [];
        }
        return $this->headers;
    }

    /**
     * Set headers
     *
     * @param string|string[] $headers
     *
     * @throws Exception\InvalidArgumentException
     *
     * @return $this
     */
    public function setHeaders($headers)
    {
        if (!is_array($headers)) {
            $headers = explode(',', $headers);
        }
        foreach ($headers as $header) {
            if (preg_match(self::HEADER_PATTERN, $header) < 1) {
                throw new Exception\InvalidArgumentException('Invalid header');
            }
        }
        $this->headers = $headers;
        return $this;
    }

    /**
     * Get secure
     *
     * @return null|bool
     */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * Set secure
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
