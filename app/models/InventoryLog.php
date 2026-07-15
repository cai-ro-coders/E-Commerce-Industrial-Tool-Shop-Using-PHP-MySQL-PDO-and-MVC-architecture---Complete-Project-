<?php

namespace App\Models;

class InventoryLog extends Model
{
    protected $table = 'inventory_logs';
    protected $fillable = ['product_id','type','quantity','reference','remarks'];
}
