<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'first_name',
        'last_name',
        'email',
        'gender',
        'position',
        'department_id',
        'address',
        'phone',
        'city',
        'state',
        'pincode',
        'salary',
        'resume',
        'certificate',
        'status',
        'profile',
        'join_date',
        'join_date_edits',
        'offer_letter',
        'joining_letter',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function attendances() {
        return $this->hasMany(Attendance::class);
    }
    public function payrolls() {
        return $this->hasMany(Payroll::class);
    }
}