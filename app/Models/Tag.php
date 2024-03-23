<?php

namespace App\Models;

use App\Models\Service;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $table = "tags";

    protected $guarded = ["id"];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
