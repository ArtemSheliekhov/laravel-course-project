@extends("main", ["title" => "Customer Service - Create"])

@section("content")
<div class="container">
    <form id="createServiceForm">
        @csrf
        <div class="row gy-3">

            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input name="name" class="form-control validate" required>
                <div id="name-error" class="invalid-feedback"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Price ($)</label>
                <input type="number" step="0.01" name="price" class="form-control validate" required>
                <div id="price-error" class="invalid-feedback"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Duration (minutes)</label>
                <input name="duration" type="number" class="form-control validate" required>
                <div id="duration-error" class="invalid-feedback"></div>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control validate"></textarea>
                <div id="description-error" class="invalid-feedback"></div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Create Service</button>
            </div>

        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$(function () {
    $('.validate').on('change', function () {
        const elem = this;
        $.post('/customerServices/validate', {
            _token: "{{ csrf_token() }}",
            name: elem.name,
            value: elem.value
        }, function (res) {
            const errorElem = $('#' + elem.name + '-error');
            if (res.error !== '') {
                $(elem).addClass('is-invalid');
                errorElem.text(res.error);
            } else {
                $(elem).removeClass('is-invalid');
                errorElem.text('');
            }
        });
    });

    $('#createServiceForm').on('submit', function (e) {
        e.preventDefault();

        if ($('input.is-invalid, textarea.is-invalid').length > 0) {
            alert("Please fix validation errors first.");
            return;
        }

        $.post("/customerServices/create", $(this).serialize(), function () {
            alert("Service created successfully!");
            window.location.href = "/customerServices";
        }).fail(function (xhr) {
            const errors = xhr.responseJSON?.errors;
            for (const key in errors) {
                $('[name="' + key + '"]').addClass('is-invalid');
                $('#' + key + '-error').text(errors[key][0]);
            }
        });
    });
});
</script>
@endsection
