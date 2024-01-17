<!-- tasks.store.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ isset($task) ? 'Edit Task' : 'Create Task' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST"
                        action="{{ isset($task) ? route('task.update', $task->uuid) : route('task.store') }}"
                        class="mb-4">
                        @csrf

                        @if (isset($task))
                            @method('PATCH')
                        @endif

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-400">Title:</label>
                            <input type="text" name="title" id="title"
                                value="{{ old('title', $task->title ?? '') }}"
                                class="w-full p-2 mt-1 border rounded dark:bg-gray-700 dark:text-white">
                        </div>

                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-400">Description:</label>
                            <textarea name="description" id="description" class="w-full p-2 mt-1 border rounded dark:bg-gray-700 dark:text-white">{{ old('description', $task->description ?? '') }}</textarea>
                        </div>

                        <div class="mb-4 {{ isset($task) ? '' : 'hidden' }}">
                            <label for="status" class="block text-sm font-medium text-gray-400">Status:</label>
                            <select name="status" id="status"
                                class="w-full p-2 mt-1 border rounded dark:bg-gray-700 dark:text-white">
                                @foreach (\App\Enums\TasksStatusEnum::cases() as $status)
                                    <option value="{{ $status->value }}"
                                        {{ old('status', $task && $task->status->value ?? '') == $status->value ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="priority" class="block text-sm font-medium text-gray-400">Priority:</label>
                            <select name="priority" id="priority"
                                class="w-full p-2 mt-1 border rounded dark:bg-gray-700 dark:text-white">
                                @foreach (\App\Enums\TasksPriorityEnum::cases() as $priority)
                                    <option value="{{ $priority->value }}"
                                        {{ old('priority', $task && $task->priority->value ?? '') == $priority->value ? 'selected' : '' }}>
                                        {{ $priority->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="deadline" class="block text-sm font-medium text-gray-400">Deadline:</label>
                            <input type="date" name="deadline" id="deadline"
                                value="{{ old('deadline', $task && $task->deadline ? \Carbon\Carbon::createFromFormat('d/m/Y', $task->deadline)->toDateString() : '') }}"
                                class="w-full p-2 mt-1 border rounded dark:bg-gray-700 dark:text-white">
                        </div>

                        <input hidden type="text" name="uuid" id="uuid"
                            value="{{ old('uuid', $task ? $task->uuid : '') }}">

                        <div class="mb-4">
                            <button type="submit"
                                class="px-4 py-2 font-bold text-white bg-blue-700 rounded hover:bg-blue-900">
                                {{ isset($task) ? 'Update Task' : 'Create Task' }}
                            </button>
                        </div>
                    </form>

                    @if ($errors->any())
                        <div class="p-4 mb-4 text-white bg-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
