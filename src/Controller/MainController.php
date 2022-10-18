<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\Controller;

use Sabel\RunConsoleBundle\Service\ConsoleRunner;
use Sabel\RunConsoleBundle\Service\Responder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/run-console/{command}',
    methods: ['GET']
)]
final class MainController
{
    public function __construct(
        private readonly Responder $responder,
        private readonly ConsoleRunner $runner
    ) {
    }

    public function __invoke(string $command): Response
    {
        $output = $this->runner->run($command)->getOutput();

        return $this->responder->response($output);
    }
}
