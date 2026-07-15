<?php

namespace App\Models;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['category_id','brand_id','sku','name','slug','short_description','description','price','sale_price','cost_price','weight','dimensions','stock_quantity','minimum_stock','featured','status'];
    protected $searchable = ['name','sku','short_description'];
}
