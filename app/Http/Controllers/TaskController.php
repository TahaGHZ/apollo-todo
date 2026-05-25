<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Store a new task inside one of the authenticated user's projects
    public function store(Request $request, string $projectId)
    {
        $project = auth()->user()
            ->projects()
            ->where('id', $projectId)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:todo,in_progress,done'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        $project->tasks()->create($validated);

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Task created successfully.');
    }

    // Redirect to the task edit page
    public function edit(string $projectId, string $taskId)
    {
        $project = auth()->user()
            ->projects()
            ->where('id', $projectId)
            ->firstOrFail();

        $task = $project->tasks()
            ->where('id', $taskId)
            ->firstOrFail();

        return view('tasks.edit', [
            'project' => $project,
            'task' => $task,
        ]);
    }

    // Update a task and redirect back to the project details page
    public function update(Request $request, string $projectId, string $taskId)
    {
        $project = auth()->user()
            ->projects()
            ->where('id', $projectId)
            ->firstOrFail();

        $task = $project->tasks()
            ->where('id', $taskId)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:todo,in_progress,done'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Task updated successfully.');
    }

    // Delete a task from one of the authenticated user's projects
    public function destroy(string $projectId, string $taskId)
    {
        $project = auth()->user()
            ->projects()
            ->where('id', $projectId)
            ->firstOrFail();

        $task = $project->tasks()
            ->where('id', $taskId)
            ->firstOrFail();

        $task->delete();

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Task deleted successfully.');
    }
}