<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'name','slug','parent_id','is_visible','description'
    ];

    //a category can belong to itself
    public function parent(): BelongsTo
    {
        return $this -> belongsTo(Category::class, foreignKey:'parent_id');
    }

    //a category can have many sub-categories
    public function child(): HasMany
    {
        return $this -> hasMany(Category::class,foreignKey:'parent_id');
    }

    //one or many categories can belong to one or many products 
    public function products(): BelongsToMany
    {
        return $this -> belongsToMany(Product::class);
    }
}
