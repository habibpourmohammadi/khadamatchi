<?php

namespace App\Models;

use App\Models\User;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "cities";

    protected $guarded = ["id"];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, "province_id");
    }
}
