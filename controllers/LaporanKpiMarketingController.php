<?php

namespace PHPMaker2021\production2;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * laporan_kpi_marketing controller
 */
class LaporanKpiMarketingController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "LaporanKpiMarketing");
    }
}
