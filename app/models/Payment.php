<?php

namespace App\Models;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['order_id','transaction_id','payment_gateway','amount','currency','status','paid_at'];
}
