<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Project
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('projects.update', $project) }}" class="bg-white p-6 shadow rounded">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="name" class="block font-medium">Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $project->name) }}"
                        class="border rounded w-full"
                    >

                    @error('name')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block font-medium">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="border rounded w-full"
                    >{{ old('description', $project->description) }}</textarea>

                    @error('description')
                        <p class="text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="text-blue-600 underline">
                    Update Project
                </button>

                <a href="{{ route('projects.show', $project) }}" class="ml-4 text-gray-600 underline">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</x-app-layout>