<?php

namespace App\Models;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = ['product_id','user_id','rating','title','comment','status'];
    protected $searchable = ['title','comment'];
}
