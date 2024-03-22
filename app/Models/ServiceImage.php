<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "service_images";

    protected $guarded = ["id"];


    public function service()
    {
        return $this->belongsTo(Service::class, "service_id");
    }
}
