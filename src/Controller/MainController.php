<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\Controller;

use Sabel\RunConsoleBundle\Service\ConsoleRunner;
use Sabel\RunConsoleBundle\Service\Responder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/healthz", methods={"GET"})
 */
#[Route(
    path: '/run-console/{command}',
    methods: ['GET']
)]
final class MainController
{
    public function __invoke(string $command): JsonResponse
    {
        $this->runner->run($command);

        return $this->responder->response();
    }

    public function __construct(
        private readonly Responder $responder,
        private readonly ConsoleRunner $runner
    )
    {
    }
}
