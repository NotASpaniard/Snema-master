<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'name','email', 'password', 'gender', 'phone_number', 'birth_date'];
}
