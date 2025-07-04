<div class="container">
    <form method="post" action="/customers/edit/{{ $model->Id }}">
        @csrf
        <div class="row gy-3">
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input name="name" value="{{ $model->Name }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ $model->Email }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input name="phone" value="{{ $model->Phone }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">IsActive</label>
                <input name="isActive" value="{{ $model->IsActive }}" class="form-control">
            </div>
                    
            <div class="col-md-6">
                <label class="form-label">Badges</label>
                <select name="badges[]" class="form-select" multiple>
                    @foreach($badges as $badge)
                        <option value="{{ $badge->Id }}"
                          {{ $model->badges->contains('Id', $badge->Id) ? 'selected' : '' }}>
                          {{ $badge->Name }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Hold Ctrl (Cmd on Mac) to select multiple badges.</small>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>

        </div>
    </form>
</div>
