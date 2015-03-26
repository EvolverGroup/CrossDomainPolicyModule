<?php
/**
 * This file is part of the evolver cross-domain policy project.
 *
 * @copyright Copyright (c) 2015, evolver media GmbH & Co. KG <info@evolver.de>
 * @author    Daniel Schröder <daniel.schroeder@evolver.de>
 */

namespace Evolver\CrossDomainPolicyModuleTest\Integration\Controller;

use Evolver\CrossDomainPolicyModuleTest\Util\ModuleLoader;
use Zend\Console\Console;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Request;
use Zend\Mvc\Application;
use Zend\Stdlib\Exception;
use Zend\Stdlib\Parameters;
use Zend\Uri\Http as Uri;

/**
 * Abstract controller test case
 *
 * @package Evolver\CrossDomainPolicyModuleTest\Integration\Controller
 */
abstract class AbstractControllerTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Application
     *
     * @var \Zend\Mvc\Application
     */
    protected $application;

    /**
     * Get the application config
     *
     * @return array
     */
    abstract public function getApplicationConfig();

    /**
     * Get the application
     *
     * @return \Zend\Mvc\Application
     */
    public function getApplication()
    {
        if (!$this->application instanceof Application) {
            Console::overrideIsConsole(false);

            $applicationConfig = $this->getApplicationConfig();
            $moduleLoader = new ModuleLoader($applicationConfig);

            $serviceManager = $moduleLoader->getServiceManager();
            $config = $serviceManager->get('Config');

            $listeners = [];
            if (isset($applicationConfig['listeners'])) {
                $listeners = $applicationConfig['listeners'];
            }
            if (isset($config['listeners'])) {
                $listeners = array_unique(array_merge($listeners, $config['listeners']));
            }

            $application = $serviceManager->get('Application');
            $application->bootstrap($listeners);

            $listener = $serviceManager->get('SendResponseListener');
            if ($listener instanceof ListenerAggregateInterface) {
                $application->getEventManager()->detach($listener);
            }

            $this->application = $application;
        }

        return $this->application;
    }

    /**
     * Get the service manager
     *
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->getApplication()->getServiceManager();
    }

    /**
     * Get the request
     *
     * @return \Zend\Http\PhpEnvironment\Request
     */
    public function getRequest()
    {
        return $this->getApplication()->getRequest();
    }

    /**
     * Get the response
     *
     * @return \Zend\Http\PhpEnvironment\Response
     */
    public function getResponse()
    {
        return $this->getApplication()->getResponse();
    }

    /**
     * Dispatch the request
     *
     * @param string $url
     * @param string $method
     * @param array  $params
     *
     * @return $this
     */
    public function dispatch($url, $method = Request::METHOD_GET, $params = [])
    {
        $request = $this->getRequest();
        $query = $request->getQuery()->toArray();
        $post = $request->getPost()->toArray();

        $uri = new Uri($url);
        $queryString = $uri->getQuery();
        if ($queryString) {
            parse_str($queryString, $query);
        }

        switch ($method) {
            case Request::METHOD_GET:
                $query = array_merge($query, $params);
                break;
            case Request::METHOD_POST:
                if (count($params) != 0) {
                    $post = $params;
                }
                break;
            case Request::METHOD_PUT:
            case Request::METHOD_PATCH:
                if (count($params) != 0) {
                    $content = http_build_query($params);
                    $request->setContent($content);
                }
                break;
            default:
                if ($params) {
                    trigger_error(
                        'Additional params is only supported by GET, POST, PUT and PATCH HTTP method',
                        E_USER_NOTICE
                    );
                }
        }

        $request->setMethod($method);
        $request->setQuery(new Parameters($query));
        $request->setPost(new Parameters($post));
        $request->setUri($uri);
        $request->setRequestUri($uri->getPath());

        $this->getApplication()->run();

        return $this;
    }
}
