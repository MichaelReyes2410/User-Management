<x-app-web-layout>
    <div class="container mt-5">
        <h2>Tasks</h2>

        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create New Task</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ ucfirst($task->status) }}</td>
                        <td>{{ ucfirst($task->priority) }}</td>
                        <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No Due Date' }}</td>
                        <td>
                            @if (!$task->archived)
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-success btn-sm">Edit</a>

                                <form action="{{ route('tasks.archive', $task->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Archive</button>
                                </form>

                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @else
                                <form action="{{ route('tasks.restore', $task->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">Restore</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-web-layout>
