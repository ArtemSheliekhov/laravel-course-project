@extends("main", ["title" => "Customer - Create"])

@section("content")
<div class="container">
    <form id="createCustomerForm">
        @csrf
        <div class="row gy-3">

            <!-- Existing inputs -->
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input name="name" class="form-control validate" required>
                <div id="name-error" class="invalid-feedback"></div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control validate" required>
                <div id="email-error" class="invalid-feedback"></div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input name="phone" class="form-control validate">
                <div id="phone-error" class="invalid-feedback"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Badges</label>
                <select name="badges[]" class="form-select" multiple>
                    @foreach($badges as $badge)
                        <option value="{{ $badge->Id }}">{{ $badge->Name }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Hold Ctrl (Cmd on Mac) to select multiple badges.</small>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Create Customer</button>
            </div>

        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$(function() {
    $('.validate').on('change', function () {
        const elem = this;
        $.ajax({
            url: '/customers/validate',
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                name: elem.name,
                value: elem.value
            },
            dataType: 'json',
            success: function (result) {
                const errorElem = document.getElementById(elem.name + '-error');
                if (result.error !== '') {
                    elem.classList.add('is-invalid');
                    errorElem.textContent = result.error;
                } else {
                    elem.classList.remove('is-invalid');
                    errorElem.textContent = '';
                }
            }
        });
    });

    $('#createCustomerForm').on('submit', function (event) {
        event.preventDefault();

        if ($('input.is-invalid').length !== 0) {
            alert("Please fix the validation errors before submitting.");
            return;
        }

        $.ajax({
            url: "/customers/create",
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                alert("Customer created successfully!");
                window.location.href = "/customers";
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    for (const field in errors) {
                        const input = $('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        $('#' + field + '-error').text(errors[field][0]);
                    }
                } else {
                    alert("Something went wrong. Please try again.");
                }
            }
        });
    });
});
</script>
@endsection
