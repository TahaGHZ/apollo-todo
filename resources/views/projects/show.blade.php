<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>
            <form method="POST" action="{{ route('projects.destroy', $project) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this project?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-small">Delete Project</button>
            </form>
        </div>
    </x-slot>

    <div class="page-shell">
        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid-two">
            <!-- Left Side: Project details and Tasks -->
            <div class="section-card section-padding">
                <div style="margin-bottom: 20px;">
                    <p class="page-kicker">Project detail</p>
                    <p class="section-subtitle" style="font-size: 15px; margin: 4px 0 0;">{{ $project->description ?? 'No description.' }}</p>
                </div>

                <!-- Add Task Form -->
                <div class="quick-task">
                    <h3 class="label" style="margin-bottom: 12px;">Add Task</h3>
                    <form method="POST" action="{{ route('projects.tasks.store', $project) }}" class="form-stack">
                        @csrf
                        <div class="form-group">
                            <label class="label" for="task-title">Task title</label>
                            <input id="task-title" name="title" class="input" placeholder="Add task title" value="{{ old('title') }}" required>
                            @error('title')
                                <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="label" for="task-desc">Description</label>
                            <textarea id="task-desc" name="description" class="textarea" placeholder="Task description">{{ old('description') }}</textarea>
                            @error('description')
                                <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label" for="task-status">Status</label>
                                <select id="task-status" name="status" class="select">
                                    <option value="todo" @selected(old('status', 'todo') === 'todo')>todo</option>
                                    <option value="in_progress" @selected(old('status') === 'in_progress')>in progress</option>
                                    <option value="done" @selected(old('status') === 'done')>done</option>
                                </select>
                                @error('status')
                                    <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="label" for="task-priority">Priority</label>
                                <select id="task-priority" name="priority" class="select">
                                    <option value="low" @selected(old('priority') === 'low')>low</option>
                                    <option value="medium" @selected(old('priority', 'medium') === 'medium')>medium</option>
                                    <option value="high" @selected(old('priority') === 'high')>high</option>
                                </select>
                                @error('priority')
                                    <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label" for="task-due-date">Due date</label>
                            <input id="task-due-date" name="due_date" type="date" class="input" value="{{ old('due_date') }}">
                            @error('due_date')
                                <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Create Task</button>
                    </form>
                </div>

                <!-- Task List -->
                <div class="task-list">
                    <h3 class="label" style="margin-bottom: 8px;">Tasks ({{ $project->tasks->count() }})</h3>
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
                            <h4 class="empty-title">No tasks yet</h4>
                            <p>Add your first task to start tracking progress.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Side: Edit Project form -->
            <aside class="section-card section-padding" id="profile-style">
                <h2 class="section-title">Edit Project Details</h2>
                <p class="section-subtitle">Inspired by Laravel Breeze profile pages: white card, simple header, form spacing, clean buttons.</p>
                <div class="divider"></div>
                <form method="POST" action="{{ route('projects.update', $project) }}" class="form-stack">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label class="label" for="project-name">Project name</label>
                        <input id="project-name" name="name" class="input" value="{{ old('name', $project->name) }}" required>
                        @error('name')
                            <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="label" for="project-description">Description</label>
                        <textarea id="project-description" name="description" class="textarea">{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="btn-row">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </aside>
        </div>
    </div>
</x-app-layout>