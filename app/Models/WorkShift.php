<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function workers()
    {
        return $this->belongsToMany(User::class, 'shift_workers');
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, ShiftWorker::class);
    }

    public function open()
    {
        $this->active = true;
        $this->save();
        return $this;
    }

    public function close()
    {
        $this->active = false;
        $this->save();
        return $this;
    }

    public function hasUser($id_user)
    {
        return $this->workers()->where(['user_id' => $id_user])->exists();
    }

    public function removeUser($id_user)
    {
        $this->workers()->findOrFail($id_user);
        ShiftWorker::where(['user_id' => $id_user, 'work_shift_id' => $this->id])->delete();
    }
}
