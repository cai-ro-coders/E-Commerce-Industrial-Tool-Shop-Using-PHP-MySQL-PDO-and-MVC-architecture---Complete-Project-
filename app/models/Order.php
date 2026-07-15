<?php

namespace App\Models;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id','order_number','subtotal','discount','shipping_fee','tax','grand_total','payment_method','payment_status','order_status','shipping_address_id','notes'];
    protected $searchable = ['order_number'];
}
