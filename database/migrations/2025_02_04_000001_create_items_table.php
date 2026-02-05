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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('status')->index();
            $table->dateTime('expires_at')->nullable()->index();
            $table->string('source')->index();
            $table->foreignId('telegram_file_id')->nullable()->constrained('telegram_files', 'id')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
