<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Apply filters to a query builder instance.
     *
     * @param Builder $query The query builder instance.
     * @param array $filters The filters to apply.
     * @return Builder The modified query builder instance.
     */
    public function applyFilters(Builder $query, array $filters): Builder
    {
        $filterMap = [
            'status'   => 'status',
            'priority' => 'priority',
            'user'     => 'user_id',
        ];

        foreach ($filterMap as $filterKey => $dbColumn) {
            if (isset($filters[$filterKey])) {
                if ($filterKey === 'user') {
                    $query->whereHas('user', function ($query) use ($filters, $filterKey) {
                        $query->where('uuid', $filters[$filterKey]);
                    });
                } else {
                    $query->where($dbColumn, $filters[$filterKey]);
                }
            }
        }

        if (isset($filters['deadline_start']) && isset($filters['deadline_end'])) {
            $query->whereBetween('deadline', [
                Carbon::parse($filters['deadline_start'])->startOfDay(),
                Carbon::parse($filters['deadline_end'])->endOfDay(),
            ]);
        }

        return $query;
    }

    public function getUsers()
    {
        $users = User::whereHas('tasks')
            ->select('uuid', 'name', 'email')
            ->get();

        return $users ?? [];
    }

    public function createTask(array $data)
    {
        $data['deadline'] = Carbon::createFromFormat('d-m-Y', $data['deadline'])->format('Y-m-d');

        $data['user_id'] = auth()->user()->id;

        $task = $this->task->create($data);

        return $task;
    }

    /**
     * Retrieves a paginated list of tasks based on specified filters.
     *
     * @param array $filters The filters to be applied to the query.
     * @param int $perPage The number of tasks to be displayed per page.
     * @param int $page The current page number.
     * @throws Some_Exception_Class Description of the exception that can be thrown.
     * @return LengthAwarePaginator The paginated tasks.
     */
    public function getPaginatedTasks(array $filters, int $perPage, int $page): LengthAwarePaginator
    {
        $query = $this->task->newQuery();
        $this->applyFilters($query, $filters);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
