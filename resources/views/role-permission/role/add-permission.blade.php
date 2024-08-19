<x-app-web-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Role: {{ $role->name }}
                            <a href="{{ url('roles') }}" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('roles/' . $role->id . '/update-permissions') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                @error('permissions')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="permissions">Permissions</label>
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                class="form-check-input"
                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Update Permissions</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-web-layout>
