<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "tags";

    protected $guarded = ["id"];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
