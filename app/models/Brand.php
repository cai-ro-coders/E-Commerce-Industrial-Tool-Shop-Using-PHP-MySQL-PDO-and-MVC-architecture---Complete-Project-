<?php

namespace App\Models;

class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = ['name','slug','logo','description','status'];
    protected $searchable = ['name','description'];
}
