@extends('main', ['title' => 'Customers'])

@section('content')
<div class="m-5">
    <div>
        <div class="col-md-12 mb-3">
            <a href="/customers/create" class="btn btn-primary">Create New Customer</a>
        </div>
        <form method="GET" action="{{ url('/customers') }}" class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Search by name">
            </div>
            <div class="col-md-4">
                <input type="text" name="phone" value="{{ request('phone') }}" class="form-control" placeholder="Search by phone">
            </div>
            <div class="col-md-4">
                <select name="isActive" class="form-select">
                    <option value="">-- Filter by Status --</option>
                    <option value="1" {{ request('isActive') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('isActive') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-secondary me-2">Filter</button>
                <a href="{{ url('/customers') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
                
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Badges</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Active</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $index => $item)
            <tr id="customer-{{ $item->Id }}">
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $item->Name }}</td>
               <td>
                    @forelse ($item->badges as $badge)
                        <span class="badge" style="background-color: {{ $badge->Color }}">{{ $badge->Name }}</span>
                    @empty
                        <span class="text-muted">No badges</span>
                    @endforelse
                </td>
                <td>{{ $item->Email }}</td>
                <td>{{ $item->Phone ?? 'N/A' }}</td>
                <td>
                    @if ($item->IsActive)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>

                <td>
                    <button class="btn btn-sm btn-primary edit-event" data-customer-id="{{ $item->Id }}" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                    <button class="btn btn-sm btn-danger delete-event" data-customer-id="{{ $item->Id }}">Delete</button>
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
        <h5 class="modal-title">Edit Customer</h5>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(".delete-event").on("click", function(){
        if (!confirm("Are you sure you want to deactivate this customer?")) return;

        const elem = this;

        $.ajax({
            url: "/customers/delete/" + elem.dataset.customerId,
            method: "post",
            data: {_token: "{{ csrf_token() }}"},
            success: function() {
                const row = document.getElementById("customer-" + elem.dataset.customerId);
                const cells = row.getElementsByTagName("td");
                const activeCell = cells[4]; 
                activeCell.innerHTML = '<span class="badge bg-secondary">No</span>';
            }
        });
    });


    $(".edit-event").on("click", function(){
        const id = $(this).data("customer-id");
        $('#editModalBody').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: '/customers/edit/' + id,
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