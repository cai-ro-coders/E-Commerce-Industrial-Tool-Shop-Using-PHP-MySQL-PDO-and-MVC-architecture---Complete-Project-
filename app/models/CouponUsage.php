<?php

namespace App\Models;

class CouponUsage extends Model
{
    protected $table = 'coupon_usages';
    protected $fillable = ['coupon_id','user_id','order_id','discount_amount'];
}
