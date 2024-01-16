<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Enums\TasksStatusEnum;
use App\Enums\TasksFiltersEnum;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Api\TasksController as ApiTasksController;
use App\Models\User;

class TasksController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $tasks = $this->taskService->getPaginatedTasks(
            $request->only(TasksFiltersEnum::getValues()),
            $request->input('per_page', 5),
            $request->input('page', 1)
        );

        return view('tasks', ['tasks' => $tasks, 'users' => $this->getUsers()]);
    }

    public function store(Request $request)
    {
        return view('tasks');
    }

    public function show(string $uuid)
    {
        $task = Task::where('uuid', $uuid)->first();

        return view('task-show', ['task' => $task]);
    }

    public function destroy($uuid)
    {
        $task = Task::where('uuid', $uuid)->first();

        if ($task === null) {
            return Redirect::route('tasks.index')->with('error', 'The requested resource does not exist!');
        }

        $task->status = TasksStatusEnum::CANCELED->value;
        $task->save();

        $task->delete();

        return Redirect::route('tasks.index')->with('success', 'Task deleted successfully');
    }

    public function getUsers()
    {
        return User::whereHas('tasks')
            ->select('uuid', 'name', 'email')
            ->get();
    }
}
