<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div class="page-shell">
        <div class="section-card" style="max-width: 680px; margin: 0 auto;">
            <div class="section-header">
                <h2 class="section-title">Edit Project</h2>
                <p class="section-subtitle">Update the project name and description.</p>
            </div>
            <div class="section-padding">
                <form method="POST" action="{{ route('projects.update', $project) }}" class="form-stack">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label class="label" for="name">Name</label>
                        <input id="name" name="name" class="input" placeholder="Example: Internship Assignment" value="{{ old('name', $project->name) }}" required>
                        @error('name')
                            <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="label" for="description">Description</label>
                        <textarea id="description" name="description" class="textarea" placeholder="Short project description">{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <p style="color: var(--danger); font-size: 13px; margin: 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="btn-row">
                        <button type="submit" class="btn btn-primary">Update Project</button>
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>