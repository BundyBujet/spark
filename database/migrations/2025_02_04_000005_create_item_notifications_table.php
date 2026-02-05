<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items', 'id')->cascadeOnDelete();
            $table->string('notification_type');
            $table->dateTime('sent_at');
            $table->string('channel');
            $table->timestamps();
            $table->unique(['item_id', 'notification_type', 'sent_at'], 'item_notifications_item_type_sent_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_notifications');
    }
};
