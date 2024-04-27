<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\City;
use App\Models\Admin;
use App\Models\Service;
use App\Models\Bookmark;
use App\Models\Province;
use App\Models\ServiceComment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'slug',
        'profile_path',
        'mobile',
        'email',
        'password',
        'city_id',
        'province_id',
        'gender',
        'status',
        'account_verified_at',
        'token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['first_name', 'last_name']
            ]
        ];
    }

    public function province()
    {
        return $this->belongsTo(Province::class, "province_id");
    }

    public function city()
    {
        return $this->belongsTo(City::class, "city_id");
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function comments()
    {
        return $this->hasMany(ServiceComment::class);
    }

    public function isAdmin()
    {
        return $this->admin()->exists();
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function getUserGenderAttribute()
    {
        switch ($this->gender) {
            case 'male':
                return "مرد";
                break;

            case 'female':
                return "زن";
                break;

            default:
                return "مشخص نشده";
                break;
        }
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function hasBookmark($serviceId)
    {
        if ($this->bookmarks()->where("service_id", $serviceId)->first()) {
            return true;
        } else {
            return false;
        }
    }
}
