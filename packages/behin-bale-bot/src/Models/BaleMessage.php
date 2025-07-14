<?php

namespace BaleBot\Models;

use Illuminate\Database\Eloquent\Model;

class BaleMessage extends Model
{
    protected $fillable = [
        'user_id', 'user_message', 'bot_response', 'feedback', 'telegram_message_id',
    ];
}