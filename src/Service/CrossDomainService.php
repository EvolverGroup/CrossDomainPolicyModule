<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModule\Service;

use Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy;
use Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy\AllowAccess;
use Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy\AllowAccessIdentity;
use Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy\AllowHeaders;
use Evolver\CrossDomainPolicyModule\Options\CrossDomainPolicy\SiteControl;
use SimpleXmlElement;
use Zend\Mvc\Exception;

/**
 * Cross-Domain service
 *
 * @package Evolver\CrossDomainPolicyModule\Service
 */
class CrossDomainService
{
    /**
     * Cross-Domain policy
     *
     * @var CrossDomainPolicy
     */
    protected $crossDomainPolicy;

    /**
     * Set cross-domain policy
     *
     * @param CrossDomainPolicy $crossDomainPolicy
     *
     * @return $this
     */
    public function setCrossDomainPolicy(CrossDomainPolicy $crossDomainPolicy)
    {
        $this->crossDomainPolicy = $crossDomainPolicy;
        return $this;
    }

    /**
     * Get cross-domain policy
     *
     * @throws Exception\BadMethodCallException
     *
     * @return CrossDomainPolicy
     */
    public function getCrossDomainPolicy()
    {
        if (!$this->crossDomainPolicy instanceof CrossDomainPolicy) {
            throw new Exception\BadMethodCallException('Cross-Domain policy not set');
        }
        return $this->crossDomainPolicy;
    }

    /**
     * Add site control element
     *
     * @param SimpleXmlElement $xml
     * @param SiteControl      $siteControl
     *
     * @return $this
     */
    public function addSiteControlElement(SimpleXmlElement $xml, SiteControl $siteControl)
    {
        $metaPolicy = $siteControl->getMetaPolicy();
        if (null !== $metaPolicy) {
            $siteControl = $xml->addChild('site-control');
            $siteControl['permitted-cross-domain-policies'] = $metaPolicy;
        }
        return $this;
    }

    /**
     * Add allow access element
     *
     * @param SimpleXmlElement $xml
     * @param AllowAccess      $allowAccess
     *
     * @return $this
     */
    public function addAllowAccessElement(SimpleXmlElement $xml, AllowAccess $allowAccess)
    {
        $domain = $allowAccess->getDomain();
        if (null !== $domain) {
            $element = $xml->addChild('allow-access-from');
            $element['domain'] = $domain;

            $ports = $allowAccess->getPorts();
            if (count($ports) > 0) {
                $element['to-ports'] = implode(',', $ports);
            }

            $secure = $allowAccess->getSecure();
            if (null !== $secure) {
                $element['secure'] = $secure ? 'true' : 'false';
            }
        }

        return $this;
    }

    /**
     * Add allow headers element
     *
     * @param SimpleXmlElement $xml
     * @param AllowHeaders     $allowHeaders
     *
     * @return $this
     */
    public function addAllowHeadersElement(SimpleXmlElement $xml, AllowHeaders $allowHeaders)
    {
        $domain = $allowHeaders->getDomain();
        $headers = $allowHeaders->getHeaders();
        if (null !== $domain && count($headers) > 0) {
            $element = $xml->addChild('allow-http-request-headers-from');
            $element['domain'] = $domain;
            $element['headers'] = implode(',', $headers);

            $secure = $allowHeaders->getSecure();
            if (null !== $secure) {
                $element['secure'] = $secure ? 'true' : 'false';
            }
        }

        return $this;
    }

    /**
     * Add allow access identity element
     *
     * @param SimpleXmlElement    $xml
     * @param AllowAccessIdentity $allowAccessIdentity
     *
     * @return $this
     */
    public function addAllowAccessIdentityElement(SimpleXmlElement $xml, AllowAccessIdentity $allowAccessIdentity)
    {
        $signatory = $allowAccessIdentity->getSignatory();
        if (null !== $signatory) {
            $certificate = $signatory->getCertificate();
            if (null !== $certificate) {
                $fingerprint = $certificate->getFingerprint();
                $algorithm = $certificate->getAlgorithm();
                if (null !== $fingerprint && null !== $algorithm) {
                    $element = $xml
                        ->addChild('allow-access-from-identity')
                        ->addChild('signatory')
                        ->addChild('certificate');
                    $element['fingerprint'] = $fingerprint;
                    $element['fingerprint-algorithm'] = $algorithm;
                }
            }
        }

        return $this;
    }

    /**
     * Get cross-domain policy XML
     *
     * @return SimpleXmlElement
     */
    public function getCrossDomainPolicyXml()
    {
        $data = [
            '<?xml version="1.0"?>',
            '<!DOCTYPE cross-domain-policy SYSTEM "http://www.adobe.com/xml/dtds/cross-domain-policy.dtd">',
            '<cross-domain-policy />'
        ];
        $xml = new SimpleXmlElement(implode("\n", $data));
        $policy = $this->getCrossDomainPolicy();

        $siteControl = $policy->getSiteControl();
        if ($siteControl instanceof SiteControl) {
            $this->addSiteControlElement($xml, $siteControl);
        }

        foreach ($policy->getAllowAccess() as $allowAccess) {
            $this->addAllowAccessElement($xml, $allowAccess);
        }

        foreach ($policy->getAllowHeaders() as $allowHeaders) {
            $this->addAllowHeadersElement($xml, $allowHeaders);
        }

        foreach ($policy->getAllowAccessIdentity() as $allowAccessIdentity) {
            $this->addAllowAccessIdentityElement($xml, $allowAccessIdentity);
        }

        return $xml;
    }
}
