<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class HomeController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        return view('home.index', $this->dashboardService->getDashboardData());
    }
}