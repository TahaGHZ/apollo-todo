<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Projects') }}
            </h2>
            <a class="btn btn-primary btn-small" href="{{ route('projects.create') }}">Create Project</a>
        </div>
    </x-slot>

    <div class="page-shell">

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats Grid -->
        <section class="stats-grid">
            <div class="stat-card">
                <span class="stat-number">{{ $projectsCount }}</span>
                <span class="stat-label">Projects</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $totalTasksCount }}</span>
                <span class="stat-label">Total tasks</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $completedTasksCount }}</span>
                <span class="stat-label">Completed</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $highPriorityTasksCount }}</span>
                <span class="stat-label">High priority</span>
            </div>
        </section>

        <!-- Projects List -->
        <section class="projects-list">
            @forelse ($projects as $project)
                @php
                    $tasks = $project->tasks;
                    $total = $tasks->count();
                    $done = $tasks->where('status', 'done')->count();
                    
                    if ($total === 0) {
                        $statusLabel = 'Todo';
                        $statusClass = 'badge-todo';
                    } elseif ($done === $total) {
                        $statusLabel = 'Completed';
                        $statusClass = 'badge-done';
                    } elseif ($tasks->whereIn('status', ['in_progress', 'done'])->count() > 0) {
                        $statusLabel = 'In progress';
                        $statusClass = 'badge-progress';
                    } else {
                        $statusLabel = 'Todo';
                        $statusClass = 'badge-todo';
                    }
                @endphp

                <details class="project-card" {{ $loop->first ? 'open' : '' }}>
                    <summary class="project-summary">
                        <div>
                            <div class="project-name-row">
                                <h2 class="project-name">{{ $project->name }}</h2>
                                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </div>
                            @if ($project->description)
                                <p class="project-desc">{{ $project->description }}</p>
                            @endif
                        </div>
                        <div class="summary-meta">
                            @if ($total > 0)
                                <span class="badge badge-neutral">{{ $done }}/{{ $total }} done</span>
                            @else
                                <span class="badge badge-neutral">0 tasks</span>
                            @endif
                            <span class="chevron">⌄</span>
                        </div>
                    </summary>

                    <div class="project-body">
                        <div class="btn-row">
                            <a class="btn btn-secondary btn-small" href="{{ route('projects.show', $project) }}">View</a>
                            <a class="btn btn-secondary btn-small" href="{{ route('projects.edit', $project) }}">Edit</a>
                            <form method="POST" action="{{ route('projects.destroy', $project) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-small">Delete</button>
                            </form>
                        </div>

                        <!-- Add Task Form -->
                        <details class="quick-task" {{ old('form_project_id') == $project->id ? 'open' : '' }}>
                            <summary>
                                <div>
                                    <span class="label">Add a new task</span>
                                    <p class="hint">Create a task with title, description, status, priority, and due date.</p>
                                </div>

                                <span class="chevron">⌄</span>
                            </summary>

                            <form method="POST"
                                  action="{{ route('projects.tasks.store', $project) }}"
                                  class="form-stack">
                                @csrf

                                <input type="hidden" name="form_project_id" value="{{ $project->id }}">

                                <div class="form-group">
                                    <label for="title-{{ $project->id }}" class="label">
                                        Task title
                                    </label>

                                    <input id="title-{{ $project->id }}"
                                           type="text"
                                           name="title"
                                           value="{{ old('form_project_id') == $project->id ? old('title') : '' }}"
                                           class="input"
                                           placeholder="Example: Finalize README">

                                    @if (old('form_project_id') == $project->id)
                                        @error('title')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description-{{ $project->id }}" class="label">
                                        Description
                                    </label>

                                    <textarea id="description-{{ $project->id }}"
                                              name="description"
                                              rows="3"
                                              class="textarea"
                                              placeholder="Optional task details">{{ old('form_project_id') == $project->id ? old('description') : '' }}</textarea>

                                    @if (old('form_project_id') == $project->id)
                                        @error('description')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    @endif
                                </div>

                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="status-{{ $project->id }}" class="label">
                                            Status
                                        </label>

                                        <select id="status-{{ $project->id }}"
                                                name="status"
                                                class="select">
                                            <option value="todo"
                                                {{ old('form_project_id') == $project->id ? (old('status') == 'todo' ? 'selected' : '') : 'selected' }}>
                                                Todo
                                            </option>

                                            <option value="in_progress"
                                                {{ old('form_project_id') == $project->id && old('status') == 'in_progress' ? 'selected' : '' }}>
                                                In progress
                                            </option>

                                            <option value="done"
                                                {{ old('form_project_id') == $project->id && old('status') == 'done' ? 'selected' : '' }}>
                                                Done
                                            </option>
                                        </select>

                                        @if (old('form_project_id') == $project->id)
                                            @error('status')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="priority-{{ $project->id }}" class="label">
                                            Priority
                                        </label>

                                        <select id="priority-{{ $project->id }}"
                                                name="priority"
                                                class="select">
                                            <option value="low"
                                                {{ old('form_project_id') == $project->id && old('priority') == 'low' ? 'selected' : '' }}>
                                                Low
                                            </option>

                                            <option value="medium"
                                                {{ old('form_project_id') == $project->id ? (old('priority') == 'medium' ? 'selected' : '') : 'selected' }}>
                                                Medium
                                            </option>

                                            <option value="high"
                                                {{ old('form_project_id') == $project->id && old('priority') == 'high' ? 'selected' : '' }}>
                                                High
                                            </option>
                                        </select>

                                        @if (old('form_project_id') == $project->id)
                                            @error('priority')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="due-date-{{ $project->id }}" class="label">
                                        Due date
                                    </label>

                                    <input id="due-date-{{ $project->id }}"
                                           type="date"
                                           name="due_date"
                                           value="{{ old('form_project_id') == $project->id ? old('due_date') : '' }}"
                                           class="input">

                                    @if (old('form_project_id') == $project->id)
                                        @error('due_date')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    @endif
                                </div>

                                <div class="btn-row">
                                    <button type="submit" class="btn btn-primary">
                                        Add Task
                                    </button>
                                </div>
                            </form>
                        </details>

                        <!-- Task List -->
                        <div class="task-list">
                            @forelse ($project->tasks as $task)
                                <article class="task-card">
                                    <div>
                                        <h3 class="task-title">{{ $task->title }}</h3>
                                        @if ($task->description)
                                            <p class="task-desc">{{ $task->description }}</p>
                                        @endif
                                        <div class="badge-row">
                                            @if ($task->status === 'done')
                                                <span class="badge badge-done">done</span>
                                            @elseif ($task->status === 'in_progress')
                                                <span class="badge badge-progress">in progress</span>
                                            @else
                                                <span class="badge badge-todo">todo</span>
                                            @endif

                                            @if ($task->priority === 'high')
                                                <span class="badge badge-high">high</span>
                                            @elseif ($task->priority === 'medium')
                                                <span class="badge badge-medium">medium</span>
                                            @else
                                                <span class="badge badge-low">low</span>
                                            @endif

                                            @if ($task->due_date)
                                                <span class="badge badge-neutral">Due {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="task-actions">
                                        @if ($task->status !== 'done')
                                            <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="title" value="{{ $task->title }}">
                                                <input type="hidden" name="description" value="{{ $task->description }}">
                                                <input type="hidden" name="status" value="done">
                                                <input type="hidden" name="priority" value="{{ $task->priority }}">
                                                <input type="hidden" name="due_date" value="{{ $task->due_date }}">
                                                <button type="submit" class="btn btn-blue btn-small">Done</button>
                                            </form>
                                        @endif
                                        <a class="btn btn-secondary btn-small" href="{{ route('projects.tasks.edit', [$project, $task]) }}">Edit</a>
                                        <form method="POST" action="{{ route('projects.tasks.destroy', [$project, $task]) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-small">Delete</button>
                                        </form>
                                    </div>
                                </article>
                            @empty
                                <div class="empty-state">
                                    <h3 class="empty-title">No tasks yet</h3>
                                    <p>Add your first task to start tracking progress.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </details>
            @empty
                <div class="empty-state">
                    <h3 class="empty-title">No projects yet</h3>
                    <p>Create your first project to get started.</p>
                </div>
            @endforelse
        </section>
    </div>
</x-app-layout>