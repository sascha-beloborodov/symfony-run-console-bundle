<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\DependencyInjection;

use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Sabel\RunConsoleBundle\Controller\MainController;
use Sabel\RunConsoleBundle\Service\ConsoleRunner;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class HealthCheckExtension extends Extension
{
    /**
     * @param array<string, mixed> $configs
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);
        $container->setParameter('run_console.commands', $config['commands']);

        $this->init($container);
    }

    private function init(ContainerBuilder $container): void
    {
        $container
            ->register('run_console.runner', ConsoleRunner::class)
            ->setArgument('$commands', $container->getParameter('run_console.commands'))
            ->setAutoconfigured(true)
            ->setPublic(true)
            ->setAutowired(true);

        $container
            ->register('run_console.controller', MainController::class)
            ->setArgument('$responder', new Reference('run_console.responder'))
            ->setArgument('$runner', new Reference('run_console.runner'))
            ->setAutoconfigured(true)
            ->setPublic(true)
            ->setAutowired(true);
    }
}