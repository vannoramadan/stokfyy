<?php

namespace App\Repositories\Interfaces;

interface ReportRepositoryInterface
{
    public function getStockReport(array $filters);
    public function getIncomingReport(array $filters);
    public function getOutgoingReport(array $filters);
}
