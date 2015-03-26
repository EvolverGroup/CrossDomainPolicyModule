<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModule\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Cross-Domain policy options
 *
 * @package Evolver\CrossDomainPolicyModule\Options
 */
class CrossDomainPolicy extends AbstractOptions
{
    /**
     * Site control
     *
     * @var null|CrossDomainPolicy\SiteControl
     */
    protected $siteControl;

    /**
     * Allow access
     *
     * @var CrossDomainPolicy\AllowAccess[]
     */
    protected $allowAccess;

    /**
     * Allow access identity
     *
     * @var null|CrossDomainPolicy\AllowAccessIdentity[]
     */
    protected $allowAccessIdentity;

    /**
     * Allow HTTP request headers
     *
     * @var null|CrossDomainPolicy\AllowHeaders[]
     */
    protected $allowHeaders;

    /**
     * Get site control
     *
     * @return null|CrossDomainPolicy\SiteControl
     */
    public function getSiteControl()
    {
        return $this->siteControl;
    }

    /**
     * Set site control
     *
     * @param null|string|array|\Traversable|CrossDomainPolicy\SiteControl $siteControl
     *
     * @return $this
     */
    public function setSiteControl($siteControl)
    {
        if (is_string($siteControl)) {
            $siteControl = ['meta_policy' => $siteControl];
        }
        if (!$siteControl instanceof CrossDomainPolicy\SiteControl) {
            $siteControl = new CrossDomainPolicy\SiteControl($siteControl);
        }
        $this->siteControl = $siteControl;
        return $this;
    }

    /**
     * Get allow access
     *
     * @return CrossDomainPolicy\AllowAccess[]
     */
    public function getAllowAccess()
    {
        if (null === $this->allowAccess) {
            return [];
        }
        return $this->allowAccess;
    }

    /**
     * Set allow access
     *
     * @param array|\Traversable|CrossDomainPolicy\AllowAccess[] $allowAccess
     *
     * @return $this
     */
    public function setAllowAccess(array $allowAccess)
    {
        $this->allowAccess = array_map(function ($allowAccess) {
            if (is_string($allowAccess)) {
                $allowAccess = ['domain' => $allowAccess];
            }
            if (!$allowAccess instanceof CrossDomainPolicy\AllowAccess) {
                $allowAccess = new CrossDomainPolicy\AllowAccess($allowAccess);
            }
            return $allowAccess;
        }, $allowAccess);
        return $this;
    }

    /**
     * Get allow access identity
     *
     * @return CrossDomainPolicy\AllowAccessIdentity[]
     */
    public function getAllowAccessIdentity()
    {
        if (null === $this->allowAccessIdentity) {
            return [];
        }
        return $this->allowAccessIdentity;
    }

    /**
     * Set allow access identity
     *
     * @param array|\Traversable|CrossDomainPolicy\AllowAccessIdentity[] $allowAccessIdentity
     *
     * @return $this
     */
    public function setAllowAccessIdentity($allowAccessIdentity)
    {
        $this->allowAccessIdentity = array_map(function ($allowAccessIdentity) {
            if (!$allowAccessIdentity instanceof CrossDomainPolicy\AllowAccessIdentity) {
                $allowAccessIdentity = new CrossDomainPolicy\AllowAccessIdentity($allowAccessIdentity);
            }
            return $allowAccessIdentity;
        }, $allowAccessIdentity);
        return $this;
    }

    /**
     * Get allow HTTP request headers
     *
     * @return CrossDomainPolicy\AllowHeaders[]
     */
    public function getAllowHeaders()
    {
        if (null === $this->allowHeaders) {
            return [];
        }
        return $this->allowHeaders;
    }

    /**
     * Set allow HTTP request headers
     *
     * @param array|\Traversable|CrossDomainPolicy\AllowHeaders[] $allowHeaders
     *
     * @return $this
     */
    public function setAllowHeaders($allowHeaders)
    {
        $this->allowHeaders = array_map(function ($allowHeaders) {
            if (!$allowHeaders instanceof CrossDomainPolicy\AllowHeaders) {
                $allowHeaders = new CrossDomainPolicy\AllowHeaders($allowHeaders);
            }
            return $allowHeaders;
        }, $allowHeaders);
        return $this;
    }
}
