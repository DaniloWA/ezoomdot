<?php

namespace App\Models;

use App\Enums\TasksStatusEnum;
use App\Enums\TasksPriorityEnum;
use App\Traits\CreateUniqueSlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    use CreateUniqueSlug;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'slug',
        'status',
        'priority',
        'deadline',
        'title',
        'description',
    ];

    //TODO! atualizar casts para versão com classes
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'slug' => 'string',
        'status' => 'string',
        'priority' => 'string',
        'title' => 'string',
        'description' => 'string',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'user_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     *
     */
    protected $dates = [
        'deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            $task->uuid = Str::uuid();
            $task->slug = static::createUniqueSlug($task->title);
        });

        static::updating(function ($task) {
            if ($task->isDirty('title')) {
                $task->slug = static::createUniqueSlug($task->title);
            }
        });
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($status) => TasksStatusEnum::from($status),
            set: fn ($status) => $status instanceof TasksStatusEnum ? $status->value : TasksStatusEnum::from($status)->value
            // Converts the given value to an enum and then assigns the enum value to the attribute
        );
    }

    protected function priority(): Attribute
    {
        return Attribute::make(
            get: fn ($priority) => TasksPriorityEnum::from($priority),
            set: fn ($priority) => $priority instanceof TasksPriorityEnum ? $priority->value : TasksPriorityEnum::from($priority)->value
            // Converts the given value to an enum and then assigns the enum value to the attribute
        );
    }

    public function getDeadlineAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function getDeletedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    //***  RELATIONS  ***/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
