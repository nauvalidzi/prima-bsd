<?php

namespace PHPMaker2021\distributor;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * print_suratjalan controller
 */
class PrintSuratjalanController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PrintSuratjalan");
    }
}
