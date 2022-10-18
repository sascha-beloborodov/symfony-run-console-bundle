<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\Service;

use Symfony\Component\HttpFoundation\Response;

final class Responder
{
    public function response(string $content): Response
    {
        return new Response($content);
    }
}
