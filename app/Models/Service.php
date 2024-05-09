<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\City;
use App\Models\User;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Province;
use App\Models\ServiceImage;
use App\Models\ServiceComment;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $table = "services";

    protected $guarded = ["id"];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function province()
    {
        return $this->belongsTo(Province::class, "province_id");
    }

    public function city()
    {
        return $this->belongsTo(City::class, "city_id");
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(ServiceComment::class);
    }

    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }

    /**
     * Retrieve active images associated with the service.
     */
    public function activeImages()
    {
        // Retrieve images associated with the service that have "active" status
        return $this->images()->where("status", "active")->get();
    }

    public function getWorkExperienceAttribute()
    {
        $unit = '';
        switch ($this->work_experience_unit) {
            case 'year':
                $unit = "سال";
                break;

            case 'month':
                $unit = "ماه";
                break;
        }

        return $this->work_experience_duration . ' ' . $unit;
    }

    /**
     * Scope a query to search for a specific value in title or slug.
     */
    public function scopeSearch($query, $value)
    {
        $query->where("title", "like", "%{$value}%")->orWhere("slug", "like", "%{$value}%");
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
