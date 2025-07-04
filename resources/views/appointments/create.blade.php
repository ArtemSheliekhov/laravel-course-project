@extends("main")
@section("content")
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-white border-bottom py-3">
                    <h4 class="mb-0 fw-bold text-primary"><i class="fas fa-calendar-plus me-2"></i>New Appointment</h4>
                </div>
                <div class="card-body">
                    <form id="createAppointmentForm">
                        @csrf

                        <!-- Customer Selection -->
                        <div class="mb-4">
                            <label for="CustomerId" class="form-label fw-bold">Customer</label>
                            <select name="CustomerId" class="form-select rounded-pill py-2" required>
                                <option value="" disabled selected>Select a customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->Id }}">{{ $customer->Name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Service Selection -->
                        <div class="mb-4">
                            <label for="ServiceId" class="form-label fw-bold">Service</label>
                            <select name="ServiceId" class="form-select rounded-pill py-2" required>
                                <option value="" disabled selected>Select a service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->Id }}" data-duration="{{ $service->Duration }}">
                                        {{ $service->Name }} ({{ $service->Duration }} minutes)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="StartDateTime" class="form-label fw-bold">Start Date & Time</label>
                                <input type="datetime-local" name="StartDateTime" class="form-control rounded-pill py-2" required>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="EndDateTime" class="form-label fw-bold">End Date & Time</label>
                                <input type="datetime-local" name="EndDateTime" class="form-control rounded-pill py-2" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="AppointmentDate" class="form-label fw-bold">Appointment Date</label>
                            <input type="date" name="AppointmentDate" class="form-control rounded-pill py-2" required>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select rounded-pill py-2" required>
                                <option value="confirmed">Confirmed</option>
                                <option value="pending">Pending</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 me-md-2" onclick="window.history.back()">
                                <i class="fas fa-times me-1"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-save me-1"></i> Create Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    const now = new Date();
    const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    const dateString = now.toISOString().split('T')[0];
    
    $('input[name="StartDateTime"]').val(`${dateString}T${timeString}`);
    $('input[name="EndDateTime"]').val(`${dateString}T${timeString}`);
    $('input[name="AppointmentDate"]').val(dateString);

    $('#createAppointmentForm').on('submit', function(event) {
        event.preventDefault();
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...');

        $.ajax({
            url: "/appointments/create",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                const successToast = `
                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header bg-success text-white">
                                <strong class="me-auto">Success</strong>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                Appointment created successfully!
                            </div>
                        </div>
                    </div>
                `;
                $('body').append(successToast);
                
                setTimeout(() => {
                    window.location.href = "/appointments";
                }, 1500);
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Create Appointment');
                
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    let errorMsg = "";
                    for (const field in errors) {
                        errorMsg += `<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            ${errors[field][0]}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                    }
                    $('#createAppointmentForm').prepend(errorMsg);
                } else {
                    $('#createAppointmentForm').prepend(`
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            Something went wrong. Please try again.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            }
        });
    });

    $('select[name="ServiceId"]').change(function() {
        updateEndTime();
    });

    $('input[name="StartDateTime"]').change(function() {
        updateEndTime();
    });

    function updateEndTime() {
        const serviceId = $('select[name="ServiceId"]').val();
        const startTime = $('input[name="StartDateTime"]').val();
        
        if (serviceId && startTime) {
            const duration = parseInt($('select[name="ServiceId"] option:selected').data('duration'));
            
            if (!isNaN(duration)) {
                const startDate = new Date(startTime);
                const endDate = new Date(startDate.getTime() + duration * 60000);
                const endDateString = formatDateTimeForInput(endDate);
                $('input[name="EndDateTime"]').val(endDateString);
            }
        }
    }
    
    function formatDateTimeForInput(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        
        return `${year}-${month}-${day}T${hours}:${minutes}`;
    }
});
</script>
@endsection
    