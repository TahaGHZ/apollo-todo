<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    
    // Displays a listing of projects for the associated authed user.
    //fetch all projects of the user and the associated tasks (from newest to oldest)
    public function index()
    {
        $projects = auth()->user()
            ->projects()
            ->withCount('tasks')
            ->with(['tasks' => function ($query) {
                $query->latest();
            }])
            ->latest()
            ->get();

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    // redirect to the project creation form
    public function create()
    {
        return view('projects.create');
    }

    // store the new project in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
        ]);

        auth()->user()->projects()->create($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    // selected project details page (view)
    // now queries the tasks associated to the project : from newest to oldest
    public function show(string $id)
    {
        $project = auth()->user()
            ->projects()
            ->with(['tasks' => function ($query) {
                $query->latest();
            }])
            ->where('id', $id)
            ->firstOrFail();

        return view('projects.show', [
            'project' => $project,
        ]);
    }

    // redirect to project edit page
    public function edit(string $id)
    {
        $project = auth()->user()
            ->projects()
            ->where('id', $id)
            ->firstOrFail();

        return view('projects.edit', [
            'project' => $project,
        ]);
    }

    // modify project and redirect to the project details page
    public function update(Request $request, string $id)
    {
        $project = auth()->user()
            ->projects()
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    // delete project
    public function destroy(string $id)
    {
        $project = auth()->user()
            ->projects()
            ->where('id', $id)
            ->firstOrFail();

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }



}
