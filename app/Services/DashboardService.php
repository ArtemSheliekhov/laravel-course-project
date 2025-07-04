<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\CustomerService;
use Illuminate\Support\Facades\Auth;


class DashboardService
{

    public function getDashboardData()
    {
        $userId = Auth::id();

        return [
            'todayAppointments' => $this->getTodayAppointmentsCount($userId),
            'newCustomersThisMonth' => $this->getNewCustomersThisMonthCount($userId),
            'activeServicesCount' => $this->getActiveServicesCount($userId),
            'popularService' => $this->getMostPopularService($userId),
            'recentAppointments' => $this->getRecentAppointments($userId),
        ];
    }


    protected function getTodayAppointmentsCount($userId)
    {
        return Appointment::where('UserId', $userId)
            ->whereDate('AppointmentDate', today())
            ->count();
    }


    protected function getNewCustomersThisMonthCount($userId)
    {
        return Customer::where('UserId', $userId)
            ->whereYear('createdAt', now()->year)
            ->whereMonth('createdAt', now()->month)
            ->count();
    }


    protected function getActiveServicesCount($userId)
    {
        return CustomerService::where('UserId', $userId)
            ->where('IsActive', true)
            ->count();
    }


    protected function getMostPopularService($userId)
    {
        return CustomerService::where('UserId', $userId)
            ->withCount('appointments')
            ->orderByDesc('appointments_count')
            ->first();
    }


    protected function getRecentAppointments($userId)
    {
        return Appointment::with(['customer', 'service'])
            ->where('UserId', $userId)
            ->latest()
            ->take(10)
            ->get();
    }

}