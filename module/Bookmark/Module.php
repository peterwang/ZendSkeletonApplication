<?php

namespace Bookmark;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Bookmark\Model\Bookmark;
use Bookmark\Model\BookmarkTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Bookmark\Model\BookmarkTable' => function ($sm) {
                    return new BookmarkTable($sm->get('BookmarkTableGateway'));
                },
                'BookmarkTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Bookmark());
                    return new TableGateway('bookmark', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
