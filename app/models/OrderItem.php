<?php

namespace App\Models;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $fillable = ['order_id','product_id','product_name','sku','quantity','price','total'];
}
