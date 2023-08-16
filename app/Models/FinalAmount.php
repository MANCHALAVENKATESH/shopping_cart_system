<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalAmount extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id', 'final_amount', 'next_discount'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
