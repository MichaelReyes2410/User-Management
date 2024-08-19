<x-app-web-layout>
    <div class="container mt-5">
        <h2>Create Task</h2>

        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select name="priority" class="form-control" required>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control">
            </div>

            <div class="mb-3">
                <label for="prerequisites" class="form-label">Prerequisites</label>
                <select name="prerequisites[]" class="form-control" multiple>
                    @foreach ($tasks as $task)
                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="files" class="form-label">Attach Files</label>
                <input type="file" name="files[]" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Create Task</button>
        </form>
    </div>
</x-app-web-layout>
