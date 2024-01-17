<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Enums\TasksStatusEnum;
use App\Enums\TasksFiltersEnum;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
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

    public function store(TaskStoreRequest $request)
    {
        $this->taskService->createTask($request->validated());

        return Redirect::route('tasks.index')->with('success', 'Task created successfully');
    }

    public function update(TaskUpdateRequest $request)
    {
        $task = Task::where('uuid', $request->input('uuid'))->first();

        if ($task === null) {
            return Redirect::route('task.show')->with('error', 'The requested resource does not exist!');
        }

        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->status = $request->input('status');
        $task->priority = $request->input('priority');
        $task->deadline = $request->input('deadline');
        $task->save();

        return Redirect::route('tasks.index')->with('success', 'Task updated successfully');
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
