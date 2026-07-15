<?php

namespace App\Models;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name','email','password','phone','avatar','role','status', 'remember_token','reset_token','reset_token_expires'];
    protected $searchable = ['name','email','phone'];
}
