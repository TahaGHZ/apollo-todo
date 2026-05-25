<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="page-shell">
        <div class="section-card" style="max-width: 680px; margin: 0 auto;">
            <div class="section-header">
                <h2 class="section-title">Edit Task</h2>
                <p class="section-subtitle">Modify task properties, progress state, and details.</p>
            </div>
            <div class="section-padding">
                <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}" class="form-stack">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label class="label" for="title">Title</label>
                        <input id="title" name="title" class="input" placeholder="Task title" value="{{ old('title', $task->title) }}" required>
                        @error('title')
                            <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="label" for="description">Description</label>
                        <textarea id="description" name="description" class="textarea" placeholder="Use cards, badges, and expandable task lists.">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="label" for="status">Status</label>
                            <select id="status" name="status" class="select">
                                <option value="todo" @selected(old('status', $task->status) === 'todo')>todo</option>
                                <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>in progress</option>
                                <option value="done" @selected(old('status', $task->status) === 'done')>done</option>
                            </select>
                            @error('status')
                                <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="label" for="priority">Priority</label>
                            <select id="priority" name="priority" class="select">
                                <option value="low" @selected(old('priority', $task->priority) === 'low')>low</option>
                                <option value="medium" @selected(old('priority', $task->priority) === 'medium')>medium</option>
                                <option value="high" @selected(old('priority', $task->priority) === 'high')>high</option>
                            </select>
                            @error('priority')
                                <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label" for="due_date">Due date</label>
                        <input id="due_date" name="due_date" type="date" class="input" value="{{ old('due_date', $task->due_date) }}">
                        @error('due_date')
                            <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="btn-row">
                        <button type="submit" class="btn btn-primary">Update Task</button>
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>