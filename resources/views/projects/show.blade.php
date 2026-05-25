<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow rounded">
                <p class="mb-4">
                    {{ $project->description ?? 'No description.' }}
                </p>

                <div class="flex gap-3">
                    <a href="{{ route('projects.edit', $project) }}" class="text-yellow-600 underline">
                        Edit Project
                    </a>

                    <a href="{{ route('projects.index') }}" class="text-gray-600 underline">
                        Back
                    </a>
                </div>

                <hr class="my-6">

                <h3 class="font-bold mb-4">Add Task</h3>

                <form method="POST" action="{{ route('projects.tasks.store', $project) }}" class="mb-6">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block font-medium">Title</label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title') }}"
                            class="border rounded w-full"
                        >

                        @error('title')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block font-medium">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            class="border rounded w-full"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block font-medium">Status</label>
                        <select id="status" name="status" class="border rounded w-full">
                            <option value="todo" @selected(old('status', 'todo') === 'todo')>To do</option>
                            <option value="in_progress" @selected(old('status') === 'in_progress')>In progress</option>
                            <option value="done" @selected(old('status') === 'done')>Done</option>
                        </select>

                        @error('status')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="priority" class="block font-medium">Priority</label>
                        <select id="priority" name="priority" class="border rounded w-full">
                            <option value="low" @selected(old('priority') === 'low')>Low</option>
                            <option value="medium" @selected(old('priority', 'medium') === 'medium')>Medium</option>
                            <option value="high" @selected(old('priority') === 'high')>High</option>
                        </select>

                        @error('priority')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="block font-medium">Due Date</label>
                        <input
                            id="due_date"
                            name="due_date"
                            type="date"
                            value="{{ old('due_date') }}"
                            class="border rounded w-full"
                        >

                        @error('due_date')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="text-blue-600 underline">
                        Add Task
                    </button>
                </form>

                <hr class="my-6">

                <h3 class="font-bold mb-4">Tasks</h3>

                @forelse ($project->tasks as $task)
                    <div class="mb-4 p-4 border rounded">
                        <h4 class="font-bold">
                            {{ $task->title }}
                        </h4>

                        @if ($task->description)
                            <p class="text-gray-700 mt-1">
                                {{ $task->description }}
                            </p>
                        @endif

                        <div class="text-sm text-gray-600 mt-2">
                            <p>Status: {{ str_replace('_', ' ', $task->status) }}</p>
                            <p>Priority: {{ $task->priority }}</p>

                            @if ($task->due_date)
                                <p>Due date: {{ $task->due_date }}</p>
                            @endif
                        </div>

                        <div class="mt-3 flex gap-3">
                            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="text-yellow-600 underline">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('projects.tasks.destroy', [$project, $task]) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-600 underline">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">No tasks yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>