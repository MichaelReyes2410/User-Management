<x-app-web-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Role
                            <a href="{{ url('roles') }}" class="btn btn-danger float-end" style="float: right;">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{url('roles')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">Role Name</label>
                            <input type="text" name="name" class="form-control" required/>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-web-layout>
