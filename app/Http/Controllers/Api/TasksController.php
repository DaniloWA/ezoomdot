<?php

namespace App\Http\Controllers\Api;

use App\Enums\TasksFiltersEnum;
use App\Enums\TasksStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    use ApiResponser;

    protected $task;
    protected $service;



    public function __construct(Task $task, TaskService $service)
    {
        $this->task = $task;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allowedFilters = TasksFiltersEnum::getValues();

        $filters = $request->only($allowedFilters);

        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $tasks = $this->service->getPaginatedTasks($filters, $perPage, $page);

        return $this->successResponse($tasks, 'Tasks retrieved successfully');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $userID = $request->user()->id;

        $mergeRequest = $request->merge(['user_id' => $userID])
            ->only(
                'title',
                'description',
                'status',
                'priority',
                'deadline',
                'user_id'
            );

        $task = $this->task::create($mergeRequest);

        return $this->successResponse($task, 'Task created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $task = $this->task->with(['user' => function ($query) {
            $query->select('id', 'uuid', 'name', 'email');
        }])->where('uuid', $uuid)->first();

        if ($task == null) {
            return $this->errorResponse('The searched resource does not exist', 404);
        }

        return $this->successResponse($task, 'Task retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, string $uuid)
    {
        $task = $this->task->where('uuid', $uuid)->first();

        if ($task === null) {
            return $this->errorResponse('Unable to perform the update. The requested resource does not exist!', 404);
        }

        $task->update($request->validated());

        return $this->successResponse($task, 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $task = $this->task->where('uuid', $uuid)->first();

        if ($task === null) {
            return $this->errorResponse('Unable to perform deletion. The requested resource does not exist!', 404);
        }

        $task->status = TasksStatusEnum::CANCELED->value;
        $task->save();

        $task->delete();

        return $this->successResponse([], 'Task deleted successfully');
    }
}
