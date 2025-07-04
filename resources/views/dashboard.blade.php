<x-app-layout>
    <x-slot name="header">
        <h1 class="display-6">
            <i class="fas fa-tachometer-alt me-2"></i>
            Dashboard
        </h1>
        <p class="lead mb-0">Welcome back, {{ Auth::user()->name }}! Here's your overview.</p>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="custom-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Quick Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-calendar-day fa-3x text-primary mb-2"></i>
                                <h3 class="text-primary">0</h3>
                                <p class="text-muted">Today's Appointments</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-success mb-2"></i>
                                <h3 class="text-success">0</h3>
                                <p class="text-muted">Total Customers</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <i class="fas fa-concierge-bell fa-3x text-info mb-2"></i>
                                <h3 class="text-info">0</h3>
                                <p class="text-muted">Active Services</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">Quick Actions</h6>
                            <div class="d-flex gap-3 flex-wrap">
                                <a href="/appointments/create" class="btn btn-custom-primary">
                                    <i class="fas fa-plus me-2"></i>New Appointment
                                </a>
                                <a href="/customers/create" class="btn btn-custom-secondary">
                                    <i class="fas fa-user-plus me-2"></i>Add Customer
                                </a>
                                <a href="/customerServices/create" class="btn btn-custom-secondary">
                                    <i class="fas fa-plus me-2"></i>Add Service
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>