<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\City;
use App\Models\User;
use App\Models\Category;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "services";

    protected $guarded = ["id"];

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
}
