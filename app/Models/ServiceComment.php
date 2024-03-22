<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "service_comments";

    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function service()
    {
        return $this->belongsTo(Service::class, "service_id");
    }
}
