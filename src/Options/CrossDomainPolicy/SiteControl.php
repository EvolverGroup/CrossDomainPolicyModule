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
 * Site control options
 *
 * @package Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy
 */
class SiteControl extends AbstractOptions
{
    const META_POLICY_ALL = 'all';
    const META_POLICY_BY_CONTENT_TYPE = 'by-content-type';
    const META_POLICY_BY_FTP_FILENAME = 'by-ftp-filename';
    const META_POLICY_MASTER_ONLY = 'master-only';
    const META_POLICY_NONE = 'none';

    /**
     * Meta policy
     *
     * @var null|string
     */
    protected $metaPolicy;

    /**
     * Get meta policy
     *
     * @return null|string
     */
    public function getMetaPolicy()
    {
        return $this->metaPolicy;
    }

    /**
     * Set meta policy
     *
     * @param string $metaPolicy
     *
     * @throws Exception\InvalidArgumentException
     *
     * @return $this
     */
    public function setMetaPolicy($metaPolicy)
    {
        $metaPolicy = strtolower($metaPolicy);
        if (!in_array($metaPolicy, [self::META_POLICY_ALL, self::META_POLICY_BY_CONTENT_TYPE,
            self::META_POLICY_BY_FTP_FILENAME, self::META_POLICY_MASTER_ONLY, self::META_POLICY_NONE])
        ) {
            throw new Exception\InvalidArgumentException('Invalid meta policy');
        }
        $this->metaPolicy = $metaPolicy;
        return $this;
    }
}
