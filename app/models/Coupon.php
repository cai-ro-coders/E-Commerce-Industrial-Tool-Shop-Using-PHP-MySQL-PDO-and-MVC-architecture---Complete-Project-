<?php

namespace App\Models;

class Coupon extends Model
{
    protected $table = 'coupons';
    protected $fillable = ['code','type','value','minimum_order','maximum_discount','usage_limit','used_count','start_date','end_date','status'];
    protected $searchable = ['code'];
}
