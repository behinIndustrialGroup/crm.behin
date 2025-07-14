<?php

namespace TelegramBot\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $fillable = ['chat_id', 'name', 'phone'];
}