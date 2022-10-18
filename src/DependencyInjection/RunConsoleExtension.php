<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\DependencyInjection;

use Exception;
use Sabel\RunConsoleBundle\Controller\MainController;
use Sabel\RunConsoleBundle\Service\ConsoleRunner;
use Sabel\RunConsoleBundle\Service\Responder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\KernelInterface;

final class RunConsoleExtension extends Extension
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
            ->setArgument('$kernel', new Reference(KernelInterface::class))
            ->setArgument('$output', new Reference(BufferedOutput::class))
            ->setAutoconfigured(true)
            ->setPublic(true)
            ->setAutowired(true);

        $container
            ->register('run_console.responder', Responder::class)
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
