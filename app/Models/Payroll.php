<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_name',
        'base_salary',
        'isss',
        'afp',
        'taxable_income',
        'isr',
        'net_salary',
    ];
}