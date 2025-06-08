<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = [
        'name',
        'slug',
        'parent',
        'ordering',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * parent_category
     *
     * @return void
     */
    public function parent_category()
    {
        return $this->belongsTo(ParentCategory::class, 'parent', 'id')->withDefault();
    }


}
