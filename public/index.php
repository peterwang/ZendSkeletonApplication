<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
// Zend\Mvc\Application::init(require 'config/application.config.php')->run();

$loader->loadClass('Zend\ServiceManager\ServiceManager');
$loader->loadClass('Zend\Mvc\Service\ServiceManagerConfig');
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

$appConfig = (require 'config/application.config.php');
$smConfig = isset($appConfig['service_manager']) ? $appConfig['service_manager'] : array();
$serviceManager = new ServiceManager(new ServiceManagerConfig($smConfig));
$serviceManager->setService('ApplicationConfig', $appConfig);

// if debug is on, record all triggered events.
$debugOn = (isset($_SERVER['APPLICATION_ENV'])
            && $_SERVER['APPLICATION_ENV'] === 'development'
            && isset($_GET['debug']));

if ($debugOn)
{
    $allEvents = array();
    $numEvents = 0;
    $sem = $serviceManager->get('SharedEventManager');
    $sem->attach('*', '*', function($e) {
            global $allEvents, $numEvents;
            $numEvents++;
            $allEvents[] = array(
                (string) $e->getName(),
                get_class($e->getTarget()) == 'string' ? ($e->getTarget()) : get_class($e->getTarget()),
                json_encode($e->getParams()),
                );
        }, PHP_INT_MAX);
}

$serviceManager->get('ModuleManager')->loadModules();
$serviceManager->get('Application')->bootstrap()->run();

// show these infomations at the bottom of the page
if ($debugOn)
{
    echo '<!-- BEG --><!--' . PHP_EOL;
    echo "trigger $numEvents events in total, here is the detail list:" . PHP_EOL;
    print_r($allEvents);
    echo '--><!-- END -->' . PHP_EOL;
}
