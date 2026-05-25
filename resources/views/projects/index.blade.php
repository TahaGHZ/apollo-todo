<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Projects
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('projects.create') }}" class="text-blue-600 underline">
                    Create Project
                </a>
            </div>

            @forelse ($projects as $project)
                <div class="mb-4 p-4 bg-white shadow rounded">
                    <h3 class="font-bold">
                        {{ $project->name }}
                    </h3>

                    @if ($project->description)
                        <p class="text-gray-700">
                            {{ $project->description }}
                        </p>
                    @endif

                    <div class="mt-2 flex gap-3">
                        <a href="{{ route('projects.show', $project) }}" class="text-blue-600 underline">
                            View
                        </a>

                        <a href="{{ route('projects.edit', $project) }}" class="text-yellow-600 underline">
                            Edit
                        </a>

                        <form method="POST" action="{{ route('projects.destroy', $project) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="text-red-600 underline">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p>No projects yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>