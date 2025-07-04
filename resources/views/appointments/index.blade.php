@extends ("main")
@section ("content")
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h3 class="mb-0 fw-bold text-primary"><i class="fas fa-calendar-alt me-2"></i>Event Calendar</h3>
                    <div class="btn-group">
                        <button class="btn btn-primary btn-sm create-event rounded-pill px-3 me-2" 
                        data-bs-toggle="modal" 
                        data-bs-target="#quickAddModal">
                            <i class="fas fa-plus me-1"></i> Quick Add
                        </button> 
                         <a href="/appointments/all" class="btn btn-primary 
                         btn-sm all-event rounded-pill px-3 me-2"> All </a>                     
                        <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 me-2" id="printCalendar">
                            <i class="fas fa-print me-1"></i> Print
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-cog me-1"></i> Options
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li><a class="dropdown-item" href="#" id="exportCalendar"><i class="fas fa-file-export text-primary me-2"></i> Export</a></li>
                                <li><a class="dropdown-item" href="#" id="importCalendar"><i class="fas fa-file-import text-success me-2"></i> Import</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" id="refreshCalendar"><i class="fas fa-sync-alt text-info me-2"></i> Refresh</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="m-3">
                        @livewire("calendar")
                    </div>
                </div>
                <div class="card-footer bg-light py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="legend d-flex flex-wrap">
                            <span class="badge rounded-pill bg-success me-2 mb-1 px-3 py-1"><i class="fas fa-circle me-1"></i> Confirmed</span>
                            <span class="badge rounded-pill bg-warning me-2 mb-1 px-3 py-1"><i class="fas fa-circle me-1"></i> Pending</span>
                            <span class="badge rounded-pill bg-danger me-2 mb-1 px-3 py-1"><i class="fas fa-circle me-1"></i> Cancelled</span>
                        </div>
                        <small class="text-muted fw-bold"><i class="fas fa-clock me-1"></i>Last updated: {{ now()->format('M d, Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Add Modal -->
<div class="modal fade" id="quickAddModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2"></i>Add New Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center" id="quickAddModalBody">
                 <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Save Event</button>
            </div>
        </div>
    </div>
</div>

<!-- Show Event Modal -->
<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="fas fa-calendar-day me-2"></i>Event Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center" id="showModalBody">
                 <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Clean Calendar Styles */
    .fc {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .fc-header-toolbar {
        padding: 1rem;
        margin-bottom: 0 !important;
        background: #f8f9fa;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    
    .fc-toolbar-title {
        font-weight: 600;
        color: #2c3e50;
    }
    
    .fc-button {
        background-color: #fff !important;
        border: 1px solid #dee2e6 !important;
        color: #495057 !important;
        border-radius: 50px !important;
        padding: 0.35rem 1rem !important;
        font-size: 0.875rem !important;
        transition: all 0.2s ease;
    }
    
    .fc-button:hover {
        background-color: #f1f3f5 !important;
    }
    
    .fc-button-active {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
    }
    
    .fc-daygrid-day {
        transition: all 0.2s ease;
    }
    
    .fc-daygrid-day:hover {
        background-color: #f8f9fa;
    }
    
    .fc-day-today {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    
    .fc-event {
        border-radius: 4px !important;
        border: none !important;
        padding: 3px 6px !important;
        font-size: 0.85rem !important;
        cursor: pointer !important;
        transition: all 0.2s ease;
        font-weight: 500;
    }
    
    .fc-event:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    
    .fc-col-header-cell {
        background: #f8f9fa;
        padding: 0.5rem 0;
        font-weight: 500;
    }
    
    .fc-daygrid-day-number {
        font-weight: 600;
        color: #495057;
    }
    
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .fc-toolbar-title {
            font-size: 1.2rem;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .legend {
            margin-bottom: 0.5rem;
        }
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.create-event').on("click",function() {
            $('#quickAddModalBody').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                $.ajax({
                    url: '/appointments/create',
                    method: 'GET',
                    success: function(html) {
                        $('#quickAddModalBody').html(html);
                        },
                        error: function() {
                            $('#quickAddModalBody').html('<div class="alert alert-danger">Failed to load form. Please try again.</div>');
                        }
                });
        });

        $('.all-event').on("click",function() {
                $.ajax({
                    url: '/appointments/all',
                    method: 'GET',
                    success: function(html) {
                        html(html);
                        },
                });
        });

        $('.show-event').on("click",function() {
            $('#showModalBody').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                $.ajax({
                    url: '/appointments/show',
                    method: 'GET',
                    success: function(html) {
                        $('#showModalBody').html(html);
                        },
                        error: function() {
                            $('#showModalBody').html('<div class="alert alert-danger">Failed to load event details. Please try again.</div>');
                        }
                });
        });
    });
</script>
@endsection