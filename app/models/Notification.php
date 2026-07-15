<?php

namespace App\Models;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_id', 'type', 'title', 'message', 'order_id', 'order_number', 'order_status', 'is_read'];
    protected $searchable = ['title', 'message'];
}
