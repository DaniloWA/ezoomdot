<?php

namespace App\Http\Requests;

use App\Enums\TasksStatusEnum;
use App\Traits\DefaultMessages;
use Illuminate\Validation\Rule;
use App\Enums\TasksPriorityEnum;
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
            'deadline' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return $this->defaultMessage();
    }
}
