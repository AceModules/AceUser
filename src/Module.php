<?php

namespace AceUser;

class Module
{
    public function getModuleDependencies()
    {
        return [
            'DoctrineORMModule',
            'AceDbTools',
            'AceDatagrid',
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
