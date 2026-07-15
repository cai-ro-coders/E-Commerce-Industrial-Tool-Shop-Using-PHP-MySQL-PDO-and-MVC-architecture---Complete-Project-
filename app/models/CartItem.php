<?php

namespace App\Models;

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $fillable = ['cart_id','product_id','quantity','price'];
}
