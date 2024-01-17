<?php

namespace App\Http\Requests;

use App\Enums\TasksStatusEnum;
use App\Traits\DefaultMessages;
use Illuminate\Validation\Rule;
use App\Enums\TasksPriorityEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    use DefaultMessages;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $deadline = $this->input('deadline');

        if ($deadline) {
            $formattedDeadline = Carbon::parse($deadline)->startOfDay();

            $this->merge(['deadline' => $formattedDeadline ? $formattedDeadline->format('d-m-Y')  : null]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(TasksStatusEnum::cases())],
            'priority' => ['required', Rule::in(TasksPriorityEnum::cases())],
            'deadline' => 'date|after_or_equal:today|date_format:d-m-Y',
        ];
    }

    public function messages(): array
    {
        return $this->defaultMessage();
    }
}
