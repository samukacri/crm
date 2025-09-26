<?php

namespace Webkul\Project\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Project\Contracts\Project as ProjectContract;
use Webkul\User\Models\User;
use Webkul\Contact\Models\Organization;
use Webkul\Product\Models\Product;
use Webkul\Tag\Models\TagProxy;

class Project extends Model implements ProjectContract
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
        'owner_id',
        'organization_id',
        'product_id',
    ];

    /**
     * Get the user that owns the project.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the owner of the project (alias for user).
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the organization associated with the project.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the product associated with the project.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the tasks for the project.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * The tags that belong to the project.
     */
    public function tags()
    {
        return $this->belongsToMany(TagProxy::modelClass(), 'project_tags');
    }
}