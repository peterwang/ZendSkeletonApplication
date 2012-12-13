<?php

return array(
    'router' => array(
        'routes' => array(
            'bookmark' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/b[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        ),
                    'defaults' => array(
                        'controller' => 'Bookmark\Controller\Bookmark',
                        'action'     => 'index',
                        ),
                    ),
                ),
            ),
        ),

    'controllers' => array(
        'invokables' => array(
            'Bookmark\Controller\Bookmark' => 'Bookmark\Controller\BookmarkController'
            ),
        ),

    'view_manager' => array(
        'doctype'             => 'HTML5',
        'template_map' => array(
//            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            ),
        ),
    );