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
        Schema::create('telegram_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_id')->index();
            $table->unsignedBigInteger('message_id')->nullable();
            $table->string('chat_id')->nullable();
            $table->string('telegram_file_path')->nullable();
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('source'); // 'web' | 'telegram'
            $table->string('type')->nullable(); // document, photo, audio, video
            $table->unsignedBigInteger('telegram_user_id')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('admins', 'id')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_files');
    }
};
