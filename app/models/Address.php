<?php

namespace App\Models;

class Address extends Model
{
    protected $table = 'addresses';
    protected $fillable = ['user_id','full_name','phone','address_line_1','address_line_2','city','province','postal_code','country','is_default'];
}
