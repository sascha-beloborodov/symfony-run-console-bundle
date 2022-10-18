<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\Service;


use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;

final class ConsoleRunner
{
    /**
     * @param string[] $commands
     */
    public function __construct(
        private readonly array $commands,
        private readonly KernelInterface $kernel
    )
    {
    }

    private function getApplication(): Application
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        return $application;
    }

    public function run(string $command): string
    {
        if (!$this->assertCommand($command)) {
            throw new \DomainException(sprintf('Command "%s" is unknown', $command));
        }

        $app = $this->getApplication();

        $output = new BufferedOutput();
        $app->run(new ArrayInput([
            'command' => $command
        ]), $output);

        return $output->fetch();
    }

    private function assertCommand(string $command): bool
    {
        return in_array($command, $this->commands);
    }

}
