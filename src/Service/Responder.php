<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\Service;


use Symfony\Component\HttpFoundation\JsonResponse;

final class Responder
{
    public function response(): JsonResponse
    {
        return new JsonResponse();
    }
}
