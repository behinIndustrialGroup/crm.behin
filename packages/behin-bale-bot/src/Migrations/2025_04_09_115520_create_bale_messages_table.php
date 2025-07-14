<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bale_messages', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->text('user_message');
            $table->text('bot_response');
            $table->enum('feedback', ['none', 'like', 'dislike'])->default('none');
            $table->bigInteger('telegram_message_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bale_messages');
    }
};
