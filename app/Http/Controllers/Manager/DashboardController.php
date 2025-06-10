<?php

// app/Http/Controllers/Manager/DashboardController.php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        return view('manager.dashboard', [
            'totalProducts' => $this->dashboardService->getTotalProducts(),
            'lowStockCount' => $this->dashboardService->getLowStockCount(),
            'lowStockProducts' => $this->dashboardService->getLowStockProducts(),
            'incomingToday' => $this->dashboardService->getIncomingToday(),
            'outgoingToday' => $this->dashboardService->getOutgoingToday(),
            'recentIncoming' => $this->dashboardService->getRecentIncomingTransactions(),
            'recentOutgoing' => $this->dashboardService->getRecentOutgoingTransactions(),
        ]);
    }

}

