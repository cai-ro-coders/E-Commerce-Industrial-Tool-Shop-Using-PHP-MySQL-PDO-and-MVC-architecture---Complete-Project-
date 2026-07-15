<?php

namespace App\Models;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    protected $fillable = ['user_id','product_id'];
}
