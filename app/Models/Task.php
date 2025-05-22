<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use App\Models\Scopes\TaskScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'user_id', 'amount', 'category_id', 'completion_date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePending(Builder $query)
    {
        return $query->where('status', TaskStatusEnum::PENDING);
    }

    public function scopeCompleted(Builder $query)
    {
        return $query->where('status', TaskStatusEnum::COMPLETED);
    }

    public function scopeCanceled(Builder $query)
    {
        return $query->where('status', TaskStatusEnum::CANCELED);
    }

    protected $casts = [
        'status' => TaskStatusEnum::class
    ];


    protected static function booted(): void
    {
        // ################## Anonymous global query scope ##################

        // if (auth()->check() && !auth()->user()->isAdmin()) {
        //     static::addGlobalScope('task_scope', function (Builder $builder): void {
        //         $builder->where('user_id', auth()->user()->id);
        //     });
        // }

        // ############ Dedicated class of Global query scope ##################
        static::addGlobalScope(new TaskScope());
    }
}
