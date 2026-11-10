<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_category', function (Blueprint $table) {
            $table->timestamp('added_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::table('book_category', function (Blueprint $table) {
            $table->dropColumn('added_at');
        });
    }
};