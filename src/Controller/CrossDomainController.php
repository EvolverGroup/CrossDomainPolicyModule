<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModule\Controller;

use Evolver\CrossDomainPolicyModule\Service\CrossDomainService;
use Zend\Http\Header\ContentType;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\Exception;
use Zend\Mvc\MvcEvent;

/**
 * Cross-Domain controller
 *
 * @package Evolver\CrossDomainPolicyModule\Controller
 */
class CrossDomainController extends AbstractController
{
    /**
     * Cross-Domain service
     *
     * @var CrossDomainService
     */
    protected $crossDomainService;

    /**
     * Content type
     *
     * @var ContentType
     */
    protected $contentType;

    /**
     * Get cross-domain service
     *
     * @throws Exception\BadMethodCallException
     *
     * @return CrossDomainService
     */
    public function getCrossDomainService()
    {
        if (!$this->crossDomainService instanceof CrossDomainService) {
            throw new Exception\BadMethodCallException('Cross-Domain service not set');
        }
        return $this->crossDomainService;
    }


    /**
     * Set cross-domain service
     *
     * @param CrossDomainService $crossDomainService
     *
     * @return $this
     */
    public function setCrossDomainService(CrossDomainService $crossDomainService)
    {
        $this->crossDomainService = $crossDomainService;
        return $this;
    }


    /**
     * Get content type
     *
     * @throws Exception\BadMethodCallException
     *
     * @return ContentType
     */
    public function getContentType()
    {
        if (!$this->contentType instanceof ContentType) {
            throw new Exception\BadMethodCallException('Content type not set');
        }
        return $this->contentType;
    }

    /**
     * Set content type
     *
     * @param ContentType $contentType
     *
     * @return $this
     */
    public function setContentType(ContentType $contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * Execute the request
     *
     * @param  MvcEvent $event
     *
     * @return \Zend\Http\PhpEnvironment\Response
     */
    public function onDispatch(MvcEvent $event)
    {
        $response = $this->getResponse();
        $this($this->getRequest(), $response);
        return $response;
    }

    /**
     * Handle the request
     *
     * @param Request  $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response)
    {
        $response->getHeaders()->addHeader($this->getContentType());
        $response->setContent($this->getCrossDomainService()->getCrossDomainPolicyXml()->asXML());
    }
}
