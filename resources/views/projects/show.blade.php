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
                        Edit
                    </a>

                    <a href="{{ route('projects.index') }}" class="text-gray-600 underline">
                        Back
                    </a>
                </div>

                <hr class="my-6">

                <h3 class="font-bold">Tasks</h3>
                <p class="text-gray-600">Tasks will be added in the next step.</p>
            </div>
        </div>
    </div>
</x-app-layout>