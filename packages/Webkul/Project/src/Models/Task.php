<?php

namespace Webkul\Project\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\User\Models\User;
use Webkul\Contact\Models\Organization;
use Webkul\Product\Models\Product;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'project_id',
        'user_id',
        'assigned_to',
        'parent_task_id',
        'organization_id',
        'product_id',
    ];

    /**
     * Get the project that owns the task.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that created the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that the task is assigned to.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the parent task.
     */
    public function parentTask()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    /**
     * Get the subtasks for the task.
     */
    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    /**
     * Get the organization associated with the task.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the product associated with the task.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the comments for the task.
     */
    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    /**
     * Get the attachments for the task.
     */
    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class);
    }
}