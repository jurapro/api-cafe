<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $appends = ['group'];

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'login',
        'password',
        'photo_file',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'role',
        'role_id',
        'password',
        'api_token',
        'created_at',
        'updated_at',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function generateToken()
    {
        $this->api_token = Hash::make(Str::random());
        $this->save();

        return $this->api_token;
    }

    public function hasRole($roles)
    {
        return in_array($this->role->code, $roles);
    }

    public function getGroupAttribute()
    {
        return $this->role->name;
    }

    public function logout()
    {
        $this->api_token = null;
        $this->save();
    }

    public function toDismiss()
    {
        $this->status = 'fired';
        $this->save();
        return $this;
    }
}
