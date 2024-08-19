<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'title', 'description', 'status', 'priority', 'due_date', 'user_id', 'archived'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function prerequisites(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_prerequisites', 'task_id', 'prerequisite_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(TaskFile::class);
    }
}

