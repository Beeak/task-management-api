<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The users that belong to the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'status'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
