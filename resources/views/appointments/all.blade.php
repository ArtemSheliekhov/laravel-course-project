@extends('main', ['title' => 'Appointments'])

@section('content')
<div class="m-5">
    <div class="mb-3 d-flex justify-content-between">
        <a href="/appointments/create" class="btn btn-primary">Create New Appointment</a>
    </div>

    <form method="GET" action="{{ url('/appointments/all') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="customer" value="{{ request('customer') }}" class="form-control" placeholder="Search by customer name">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">-- Filter by Status --</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-4">
            <select name="isActive" class="form-select">
                <option value="">-- Filter by Active --</option>
                <option value="1" {{ request('isActive') === '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('isActive') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-secondary me-2">Filter</button>
            <a href="{{ url('/appointments/all') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $index => $item)
            <tr id="appointment-{{ $item->Id }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->customer->Name ?? 'N/A' }}</td>
                <td>{{ $item->service->Name ?? 'N/A' }}</td>
                <td>{{ $item->AppointmentDate }}</td>
                <td>{{ \Carbon\Carbon::parse($item->StartDateTime)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->EndDateTime)->format('H:i') }}</td>
                <td><span class="badge bg-info text-dark">{{ ucfirst($item->status) }}</span></td>
                <td>
                    @if ($item->IsActive)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    <a href="/appointments/show/{{ $item->Id }}" class="btn btn-sm btn-primary edit-appointment">Edit</a>
                    <form method="POST" action="/appointments/delete/{{ $item->Id }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="editModalBody">
        <div class="text-center">
          <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
     $(".delete-event").on("click", function(){
        if (!confirm("Are you sure you want to deactivate this appointment?")) return;

        const elem = this;

        $.ajax({
            url: "/appointment/delete/" + elem.dataset.appointmentId,
            method: "post",
            data: {_token: "{{ csrf_token() }}"},
            success: function() {
                const row = document.getElementById("appointment-" + elem.dataset.appointmentId);
                const cells = row.getElementsByTagName("td");
                const activeCell = cells[7]; 
                activeCell.innerHTML = '<span class="badge bg-secondary">No</span>';
            }
        });
    });

    $(".edit-appointment").on("click", function(){
        const id = $(this).data("id");
        $('#editModalBody').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: '/appointments/edit/' + id,
            method: 'GET',
            success: function(html) {
                $('#editModalBody').html(html);
            },
            error: function() {
                $('#editModalBody').html('<p class="text-danger">Failed to load form.</p>');
            }
        });
    });
</script>
@endsection
