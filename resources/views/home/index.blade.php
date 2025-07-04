@extends ("main")
@section ("content")
<div class="container-fluid px-0">
    <!-- Welcome Header -->
    <div class="row mx-0 mb-4">
        <div class="col-12 px-0">
            <div class="card shadow-sm bg-gradient-light text-dark rounded-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">Welcome, {{ auth()->user()->name }}!</h2>
                            <p class="mb-0">Here's your business overview today</p>
                        </div>
                        <div class="display-4 text-primary">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <!-- Key Metrics -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4 px-2">
                <div class="card border-start border-primary border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-primary fw-bold text-uppercase mb-2">Today's Appointments</h6>
                                <h2 class="mb-0">{{ $todayAppointments }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-calendar-day fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="/appointments?filter=today" class="text-primary small fw-bold">
                                View all <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 px-2">
                <div class="card border-start border-success border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-success fw-bold text-uppercase mb-2">New Customers</h6>
                                <h2 class="mb-0">{{ $newCustomersThisMonth }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-user-plus fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="/customers" class="text-success small fw-bold">
                                Manage customers <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 px-2">
                <div class="card border-start border-info border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-info fw-bold text-uppercase mb-2">Active Services</h6>
                                <h2 class="mb-0">{{ $activeServicesCount }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-concierge-bell fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="/customerServices" class="text-info small fw-bold">
                                View services <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4 px-2">
                <div class="card border-start border-warning border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-warning fw-bold text-uppercase mb-2">Popular Service</h6>
                                <h2 class="mb-0">{{ $popularService->Name ?? 'N/A' }}</h2>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-star fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="/customerServices" class="text-warning small fw-bold">
                                View details <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Quick Actions -->
        <div class="row">
            <!-- Recent Appointments -->
            <div class="col-lg-8 mb-4 px-2">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Recent Appointments</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Service</th>
                                        <th>Date/Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->customer->Name }}</td>
                                        <td>{{ $appointment->service->Name }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($appointment->AppointmentDate)->format('M j') }}
                                            at {{ \Carbon\Carbon::parse($appointment->StartDateTime)->format('g:i A') }}
                                        </td>
                                        <td>
                                            @if($appointment->IsActive)
                                                <span class="badge bg-success">Confirmed</span>
                                            @else
                                                <span class="badge bg-secondary">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/appointments/show/{{ $appointment->Id }}" class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top">
                        <a href="/appointments" class="btn btn-sm btn-primary">
                            View All Appointments
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4 px-2">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="/appointments/create" class="btn btn-primary btn-lg py-3">
                                <i class="fas fa-plus-circle me-2"></i> New Appointment
                            </a>
                            <a href="/customers/create" class="btn btn-outline-primary py-3">
                                <i class="fas fa-user-plus me-2"></i> Add Customer
                            </a>
                            <a href="/customerServices/create" class="btn btn-outline-primary py-3">
                                <i class="fas fa-plus-circle me-2"></i> Add Service
                            </a>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection