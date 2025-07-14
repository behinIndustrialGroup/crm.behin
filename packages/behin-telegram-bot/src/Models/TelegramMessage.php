<?php

namespace TelegramBot\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramMessage extends Model
{
    protected $fillable = [
        'user_id', 'user_message', 'bot_response', 'feedback', 'telegram_message_id',
    ];
}