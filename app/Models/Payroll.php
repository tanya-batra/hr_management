<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id', 'month', 'year', 'basic_salary',
        'working_days', 'days_attended', 'net_salary',
        'payment_status', 'payment_date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
