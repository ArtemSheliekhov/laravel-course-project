<div class="container">
    <form method="post" action="/customerServices/edit/{{ $model->Id }}">
        @csrf
        <div class="row gy-3">

            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input name="name" value="{{ $model->Name }}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Price ($)</label>
                <input name="price" type="number" step="0.01" value="{{ $model->Price }}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Duration (minutes)</label>
                <input name="duration" type="number" value="{{ $model->Duration }}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Is Active</label>
                <select name="isActive" class="form-select">
                    <option value="1" {{ $model->IsActive ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$model->IsActive ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ $model->Description }}</textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>

        </div>
    </form>
</div>
