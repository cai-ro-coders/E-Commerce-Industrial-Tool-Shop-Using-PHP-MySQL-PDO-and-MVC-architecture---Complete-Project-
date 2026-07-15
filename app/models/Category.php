<?php

namespace App\Models;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['parent_id','name','slug','image','description','status'];
    protected $searchable = ['name','description'];
}
