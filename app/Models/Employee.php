<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function nonAttendances()
    {
        return $this->hasMany(NonAttendance::class);
    }

    public function workingDays()
    {
        return $this->hasMany(WorkingDay::class);
    }
}
