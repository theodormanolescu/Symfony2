<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AppExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $appConfig = $this->processConfiguration($configuration, $configs);

        $dashboardDefinition = $container->register('app.dashboard', 'AppBundle\Dashboard\Dashboard');
        $dashboardDefinition->addMethodCall('loadFromConfiguration', array($appConfig));
    }

}
