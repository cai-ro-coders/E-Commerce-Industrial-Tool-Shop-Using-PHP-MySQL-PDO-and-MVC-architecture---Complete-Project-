<?php

namespace App\Models;

class ProductSpecification extends Model
{
    protected $table = 'product_specifications';
    protected $fillable = ['product_id','attribute_name','attribute_value'];
}
