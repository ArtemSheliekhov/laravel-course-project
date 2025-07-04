<!-- Profile Page (profile/edit.blade.php) -->
<x-app-layout>
    <x-slot name="header">
        <h1 class="display-6">
            <i class="fas fa-user-cog me-2"></i>
            Profile Settings
        </h1>
        <p class="lead mb-0">Manage your account information and preferences.</p>
    </x-slot>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-12 mb-4">
            <div class="custom-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                                    @if($errors->get('name'))
                                        <div class="text-danger mt-2">
                                            @foreach($errors->get('name') as $error)
                                                <small>{{ $error }}</small>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    @if($errors->get('email'))
                                        <div class="text-danger mt-2">
                                            @foreach($errors->get('email') as $error)
                                                <small>{{ $error }}</small>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 align-items-center">
                            <button type="submit" class="btn btn-custom-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>

                            @if (session('status') === 'profile-updated')
                                <div class="alert alert-success alert-custom mb-0 py-2 px-3">
                                    <i class="fas fa-check me-2"></i>Profile updated successfully!
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-12 mb-4">
            <div class="custom-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-lock me-2"></i>
                        Update Password
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="update_password_current_password" class="form-label">Current Password</label>
                                    <input id="update_password_current_password" name="current_password" type="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="update_password_password" class="form-label">New Password</label>
                                    <input id="update_password_password" name="password" type="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 align-items-center">
                            <button type="submit" class="btn btn-custom-primary">
                                <i class="fas fa-key me-2"></i>Update Password
                            </button>

                            @if (session('status') === 'password-updated')
                                <div class="alert alert-success alert-custom mb-0 py-2 px-3">
                                    <i class="fas fa-check me-2"></i>Password updated successfully!
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="col-12">
            <div class="custom-card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="text-danger">Delete Account</h6>
                    <p class="text-muted mb-3">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                    
                    <button type="button" class="btn btn-custom-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash me-2"></i>Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                        <div class="form-group">
                            <label for="password" class="form-label">Please enter your password to confirm:</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom-danger">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>