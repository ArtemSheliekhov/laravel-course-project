@extends('main', ['title' => 'Customer Services'])

@section('content')
<div class="m-5">
    <div>
        <div class="col-md-12 mb-3">
            <a href="/customerServices/create" class="btn btn-primary">Create New Service</a>
        </div>

        <form method="GET" action="{{ url('/customerServices') }}" class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Search by name">
            </div>
            <div class="col-md-4">
                <select name="is_active" class="form-select">
                    <option value="">-- Filter by Status --</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-secondary me-2">Filter</button>
                <a href="{{ url('/customerServices') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price ($)</th>
                <th>Duration (min)</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($models as $index => $item)
            <tr id="customerService-{{ $item->Id }}">
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $item->Name }}</td>
                <td>{{ number_format($item->Price, 2) }}</td>
                <td>{{ $item->Duration }}</td>
                <td>
                    @if ($item->IsActive)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-primary edit-event" 
                        data-customer-service-id="{{ $item->Id }}" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editServiceModal">Edit</button>
                    <button class="btn btn-sm btn-danger delete-event"
                            data-customer-service-id="{{ $item->Id }}">
                        Delete
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Customer Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="editServiceModalBody">
        <div class="text-center">
            <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

    $(".edit-event").on("click", function(){
        const id = $(this).data("customer-service-id");
        $('#editServiceModalBody').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: '/customerServices/edit/' + id,
            method: 'GET',
            success: function(html) {
                $('#editServiceModalBody').html(html);
            },
            error: function() {
                $('#editServiceModalBody').html('<p class="text-danger">Failed to load form.</p>');
            }
        });
    });

    $(".delete-event").on("click", function () {
        console.log(this); 
        const elem = this;      
        const id = $(this).data("customer-service-id");

        if (!confirm("Are you sure you want to deactivate this service?")) return;

        $.ajax({
            url: '/customerServices/delete/' + id,
            method: 'post',
            data: {_token: "{{ csrf_token() }}"},
            success: function () {
                console.log(elem);  
                const row = document.getElementById("customerService-" + id);
                const cells = row.getElementsByTagName("td");
                const activeCell = cells[5];
                activeCell.innerHTML = '<span class="badge bg-secondary">No</span>';
            }
        });
    });

    
</script>
@endsection
