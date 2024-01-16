<!-- tasks.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <div class="mb-4">
                                <label for="user" class="block text-sm font-medium text-gray-400">User:</label>
                                <select name="user" id="user"
                                    class="mt-1 p-2 border rounded w-full dark:bg-gray-700 dark:text-white">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->uuid }}"
                                            {{ request('user') == $user->uuid ? 'selected' : '' }}>
                                            {{ $user->name ?? $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-400">Status:</label>
                                <select name="status" id="status"
                                    class="mt-1 p-2 border rounded w-full dark:bg-gray-700 dark:text-white">
                                    <option value="">Select Status</option>
                                    @foreach (\App\Enums\TasksStatusEnum::cases() as $status)
                                        <option value="{{ $status->value }}"
                                            {{ request('status') == $status->value ? 'selected' : '' }}>
                                            {{ $status->name() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="priority" class="block text-sm font-medium text-gray-400">Priority:</label>
                                <select name="priority" id="priority"
                                    class="mt-1 p-2 border rounded w-full dark:bg-gray-700 dark:text-white">
                                    <option value="">Select Priority</option>
                                    @foreach (\App\Enums\TasksPriorityEnum::cases() as $priority)
                                        <option value="{{ $priority->value }}"
                                            {{ request('priority') == $priority->value ? 'selected' : '' }}>
                                            {{ $priority->name() }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="per_page" class="block text-sm font-medium text-gray-400">Items por
                                    página:</label>
                                <select name="per_page" id="per_page"
                                    class="mt-1 p-2 border rounded w-full dark:bg-gray-700 dark:text-white">
                                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="deadline_start" class="block text-sm font-medium text-gray-400">Deadline
                                    Start:</label>
                                <input type="date" name="deadline_start" id="deadline_start"
                                    value="{{ request('deadline_start') }}"
                                    class="mt-1 p-2 border rounded w-full dark:bg-gray-700 dark:text-white">
                            </div>

                            <div class="mb-4">
                                <label for="deadline_end" class="block text-sm font-medium text-gray-400">Deadline
                                    End:</label>
                                <input type="date" name="deadline_end" id="deadline_end"
                                    value="{{ request('deadline_end') }}"
                                    class="mt-1 p-2 border rounded w-full dark:bg-gray-700 dark:text-white">
                            </div>


                            <div class="mb-4 col-span-full max-h-[100px] overflow-y-auto">
                                <button type="submit"
                                    class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded ">
                                    Apply Filters
                                </button>

                                <button type="button" onclick="resetFilters()"
                                    class="ml-2 bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded">
                                    Reset Filters
                                </button>
                            </div>

                        </div>
                    </form>
                    <hr>
                    @if ($tasks->count() > 0)
                        <ul>
                            @foreach ($tasks as $task)
                                <li class="border-b border-gray-300 p-4">
                                    <div class="text-gray-400 text-sm">
                                        <strong class="text-gray-300">User:</strong> {{ $task->user->name }}
                                    </div>
                                    <h3 class="text-xl text-gray-200 font-semibold mb-2">{{ $task->title }}</h3>
                                    <p class="text-gray-300 mb-4">{{ $task->description }}</p>
                                    <div class="flex mt-2 text-sm text-gray-400">
                                        <span class="mr-4">
                                            <strong class="text-gray-300">Status:</strong> {{ $task->status }}
                                        </span>
                                        <span class="mr-4 ">
                                            <strong class="text-gray-300">Priority:</strong> {{ $task->priority }}
                                        </span>
                                        <span>
                                            <strong class="text-gray-300">Deadline:</strong> {{ $task->deadline }}
                                        </span>
                                    </div>

                                    <div class="flex mt-2 text-sm">
                                        <a href="{{ route('tasks.update', $task->uuid) }}"
                                            class="bg-green-600 hover:bg-green-800 text-white font-bold py-1 px-4 rounded mr-3">
                                            Edit
                                        </a>
                                        <form class="deleteForm" action="{{ route('tasks.destroy', $task->uuid) }}"
                                            method="POST" data-task-id="{{ $task->uuid }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-800 text-white font-bold py-1 px-4 rounded mr-3 delete-button">
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                        <div class="spinner" role="status" style="display: none;"
                                            data-task-id="{{ $task->uuid }}">
                                            <svg aria-hidden="true"
                                                class="inline w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                    fill="currentFill" />
                                            </svg>
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-5">
                            {{ $tasks->appends(request()->query())->links() }}
                        </div>
                    @else
                        <p class="text-gray-400 dark:text-gray-300">No tasks found.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                var form = this.closest('form');
                var taskId = form.getAttribute('data-task-id');
                var spinner = document.querySelector('.spinner[data-task-id="' + taskId + '"]');

                if (confirm('Are you sure you want to delete this task?')) {
                    spinner.style.display = 'block';
                    form.submit();
                }
            });
        });

        function resetFilters() {
            window.location.href = window.location.pathname;
        }
    </script>
</x-app-layout>
