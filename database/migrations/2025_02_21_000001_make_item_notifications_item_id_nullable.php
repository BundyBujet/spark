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
        Schema::table('item_notifications', function (Blueprint $table) {
            $table->dropUnique('item_notifications_item_type_sent_unique');
            $table->dropForeign(['item_id']);
        });

        Schema::table('item_notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable()->change();
        });

        Schema::table('item_notifications', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_notifications', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
        });

        Schema::table('item_notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable(false)->change();
        });

        Schema::table('item_notifications', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->unique(['item_id', 'notification_type', 'sent_at'], 'item_notifications_item_type_sent_unique');
        });
    }
};
