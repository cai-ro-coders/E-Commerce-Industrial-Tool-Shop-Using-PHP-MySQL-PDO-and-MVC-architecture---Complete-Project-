<?php

namespace App\Models;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = ['key','group','value'];
    protected $searchable = ['key','value'];
}
