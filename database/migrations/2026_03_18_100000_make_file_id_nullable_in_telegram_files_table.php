<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telegram_files', function (Blueprint $table) {
            // file_id is only available after Telegram receives the file,
            // so pending records must be allowed to have a null file_id.
            $table->string('file_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('telegram_files', function (Blueprint $table) {
            $table->string('file_id')->nullable(false)->change();
        });
    }
};
