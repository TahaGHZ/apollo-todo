<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Task
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}" class="bg-white p-6 shadow rounded">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="title" class="block font-medium">Title</label>
                    <input
                        id="title"
                        name="title"
                        type="text"
                        value="{{ old('title', $task->title) }}"
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
                    >{{ old('description', $task->description) }}</textarea>

                    @error('description')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block font-medium">Status</label>
                    <select id="status" name="status" class="border rounded w-full">
                        <option value="todo" @selected(old('status', $task->status) === 'todo')>To do</option>
                        <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>In progress</option>
                        <option value="done" @selected(old('status', $task->status) === 'done')>Done</option>
                    </select>

                    @error('status')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="priority" class="block font-medium">Priority</label>
                    <select id="priority" name="priority" class="border rounded w-full">
                        <option value="low" @selected(old('priority', $task->priority) === 'low')>Low</option>
                        <option value="medium" @selected(old('priority', $task->priority) === 'medium')>Medium</option>
                        <option value="high" @selected(old('priority', $task->priority) === 'high')>High</option>
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
                        value="{{ old('due_date', $task->due_date) }}"
                        class="border rounded w-full"
                    >

                    @error('due_date')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="text-blue-600 underline">
                    Update Task
                </button>

                <a href="{{ route('projects.show', $project) }}" class="ml-4 text-gray-600 underline">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</x-app-layout>