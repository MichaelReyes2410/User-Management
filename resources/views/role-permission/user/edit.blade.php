<x-app-web-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit User
                            <a href="{{ url('users') }}" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('users/'.$user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required/>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required/>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control"/>
                                <small class="text-muted">Leave blank if you don't want to change the password</small>
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="roles">Roles</label>
                                <select name="roles[]" class="form-control" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}"
                                        {{ in_array($role, $userRoles) ? 'selected' : '' }}
                                        >{{ $role }}</option>                                
                                    @endforeach
                                </select>
                                @error('roles') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-web-layout>
