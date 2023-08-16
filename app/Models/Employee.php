<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['name','username','phone','email','password'];
    public function finalAmounts()
    {
        return $this->hasMany(FinalAmount::class);
    }
}
