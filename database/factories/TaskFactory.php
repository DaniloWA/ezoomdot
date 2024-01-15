<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Enums\TasksStatusEnum;
use App\Enums\TasksPriorityEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(TasksStatusEnum::cases()),
            'priority' => $this->faker->randomElement(TasksPriorityEnum::cases()),
            'deadline' => $this->faker->dateTimeBetween('now', '+5 days'),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
    }
}
