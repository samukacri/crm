<?php

namespace Webkul\Project\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\User\Models\User;

class ProjectTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'user_id',
    ];

    /**
     * Get the user that owns the project template.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}