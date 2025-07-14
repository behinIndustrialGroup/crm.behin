<?php

namespace BaleBot\Models;

use Illuminate\Database\Eloquent\Model;

class BaleUser extends Model
{
    protected $fillable = ['chat_id', 'name', 'phone'];
}