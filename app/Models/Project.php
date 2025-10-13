<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'location',
        'description',
        'year',
        'cover_image',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'canonical_url',
    ];

    public function images() {
        return $this->hasMany(ProjectImage::class);
    }
}
