<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\Service;


final class ConsoleRunner
{
    /**
     * @param string[] $commands
     */
    public function __construct(private readonly array $commands)
    {
    }

    public function run(string $command): void
    {
        if (!$this->assertCommand($command)) {
            throw new \DomainException(sprintf('Command "%s" is unknown', $command));
        }
    }

    private function assertCommand(string $command): bool
    {
        return in_array($command, $this->commands);
    }

}
