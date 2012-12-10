ZendFramework2Events
====================

    Zend\ModuleManager\ModuleManager
    loadModules
        loadModule.resolve
        loadModule
		loadModule.resolve
		loadModule
		...
    loadModules.post

    Zend\Mvc\Application
    bootstrap
    route
    dispatch

        Zend\Mvc\Controller\AbstractController
		dispatch

    Zend\Mvc\Application
    render

        Zend\View\View
        renderer
        renderer (renderChildren)
        response

    Zend\Mvc\Application
    finish
