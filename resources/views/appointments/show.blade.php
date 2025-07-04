@extends('main', ['title' => 'Appointment Details'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold text-primary">
                            <i class="fas fa-calendar-day me-2"></i>Appointment Details
                        </h3>
                        <div>
                            @if ($model->IsActive)
                                <span class="badge bg-success rounded-pill px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i> Active
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i> Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="border-bottom">
                                    <th class="py-3 text-muted" style="width: 30%">Customer</th>
                                    <td class="py-3 fw-bold">{{ $model->customer->Name }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="py-3 text-muted">Service</th>
                                    <td class="py-3 fw-bold">{{ $model->service->Name }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="py-3 text-muted">Date</th>
                                    <td class="py-3 fw-bold">
                                        <i class="far fa-calendar-alt text-primary"></i>
                                        {{ \Carbon\Carbon::parse($model->AppointmentDate)->format('F j, Y') }}
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="py-3 text-muted">Time Slot</th>
                                    <td class="py-3 fw-bold">
                                        <i class="far fa-clock text-primary"></i>
                                        {{ \Carbon\Carbon::parse($model->StartDateTime)->format('g:i A') }} - 
                                        {{ \Carbon\Carbon::parse($model->EndDateTime)->format('g:i A') }}
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="py-3 text-muted">Duration</th>
                                    <td class="py-3 fw-bold">
                                        {{ \Carbon\Carbon::parse($model->StartDateTime)->diffInMinutes(\Carbon\Carbon::parse($model->EndDateTime)) }} minutes
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ url('/appointments') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-1"></i> Back to Calendar
                        </a>
                        <div class="btn-group">
                            <div>
                            <a href="{{ url('/appointments/edit', $model->Id) }}" class="btn btn-primary rounded-pill px-4 me-2">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            </div>  
                            <form action="{{ url('/appointments/delete', $model->Id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger rounded-pill px-4" onclick="return confirm('Are you sure you want to delete this appointment?')">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection