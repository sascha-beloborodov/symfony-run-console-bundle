<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\Service;

use DomainException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use function in_array;
use function sprintf;

final class ConsoleRunner
{
    private BufferedOutput $output;

    /**
     * @param string[] $commands
     */
    public function __construct(
        private readonly array $commands,
        private readonly KernelInterface $kernel
    ) {
        $this->output = new BufferedOutput(OutputInterface::VERBOSITY_NORMAL, true);
    }

    private function getApplication(): Application
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        return $application;
    }

    public function run(string $command): self
    {
        if (!$this->checkCommand($command)) {
            throw new DomainException(sprintf('Command "%s" is unknown', $command));
        }

        $this->getApplication()->run(new ArrayInput([
            'command' => $command,
        ]), $this->output);

        return $this;
    }

    public function getOutput(): BufferedOutput
    {
        return $this->output;
    }

    private function checkCommand(string $command): bool
    {
        return in_array($command, $this->commands, true);
    }
}
