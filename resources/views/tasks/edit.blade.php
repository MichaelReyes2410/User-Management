<x-app-web-layout>
    <div class="container mt-5">
        <h2>Edit Task</h2>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" required>{{ $task->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select name="priority" class="form-control" required>
                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
            </div>

            <div class="mb-3">
                <label for="prerequisites" class="form-label">Prerequisites</label>
                <select name="prerequisites[]" class="form-control" multiple>
                    @foreach ($tasks as $potentialTask)
                        <option value="{{ $potentialTask->id }}" {{ in_array($potentialTask->id, $task->prerequisites->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $potentialTask->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="files" class="form-label">Attach Files</label>
                <input type="file" name="files[]" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </div>
</x-app-web-layout>
