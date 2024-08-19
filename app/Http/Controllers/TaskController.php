<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->tasks()->with('prerequisites', 'files')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $tasks = Auth::user()->tasks()->where('status', '!=', 'done')->get(); // Fetch tasks that are not done
        return view('tasks.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:high,medium,low',
            'due_date' => 'nullable|date',
            'prerequisites' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,png,pdf,docx,xlsx'
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'todo',
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'user_id' => Auth::id(),
        ]);

        if ($request->prerequisites) {
            $task->prerequisites()->sync($request->prerequisites);
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = $file->store('task_files');
                TaskFile::create([
                    'task_id' => $task->id,
                    'filename' => $filename
                ]);
            }
        }

        return redirect()->route('tasks.index')->with('status', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $tasks = Auth::user()->tasks()->where('status', '!=', 'done')->get();
        return view('tasks.edit', compact('task', 'tasks'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:high,medium,low',
            'due_date' => 'nullable|date',
            'prerequisites' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,png,pdf,docx,xlsx'
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ]);

        if ($request->prerequisites) {
            $task->prerequisites()->sync($request->prerequisites);
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = $file->store('task_files');
                TaskFile::create([
                    'task_id' => $task->id,
                    'filename' => $filename
                ]);
            }
        }

        return redirect()->route('tasks.index')->with('status', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        foreach ($task->files as $file) {
            Storage::delete($file->filename);
            $file->delete();
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('status', 'Task deleted successfully.');
    }

    public function archive(Task $task)
    {
        $task->update(['archived' => true]);
        return redirect()->route('tasks.index')->with('status', 'Task archived successfully.');
    }

    public function restore(Task $task)
    {
        $task->update(['archived' => false]);
        return redirect()->route('tasks.index')->with('status', 'Task restored successfully.');
    }
}
