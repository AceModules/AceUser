<?php

namespace AceUser;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'admin_entities' => [
        'user' => Entity\User::class,
        'role' => Entity\Role::class,
    ],
    'doctrine' => [
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    Entity\Subscriber\PasswordSubscriber::class,
                ],
            ],
        ],
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
    'dependencies' => [
        'aliases' => [
            'AceUserService' => Service\UserService::class,
        ],
        'factories' => [
            Service\UserService::class => Factory\UserServiceFactory::class,
        ],
    ],
];