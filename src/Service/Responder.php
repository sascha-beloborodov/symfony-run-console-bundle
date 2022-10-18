<?php

declare(strict_types = 1);

namespace Sabel\RunConsoleBundle\Service;

use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;

final class Responder
{
    public function response(BufferedOutput $output): Response
    {
        $converter = new AnsiToHtmlConverter();
        $content   = $output->fetch();

        return new Response($converter->convert($content));
    }
}
