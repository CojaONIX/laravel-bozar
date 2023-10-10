<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $timestamps = false;

    /**
     * The posts that belong to category.
     */
    public function post(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
