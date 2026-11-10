<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->dateTime('borrowed_at');
            $table->date('due_date');
            $table->string('status')->default('borrowed');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('borrowing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')
                ->constrained('borrowings')
                ->cascadeOnDelete();
            $table->foreignId('book_id')
                ->constrained('books')
                ->restrictOnDelete();
            $table->string('book_title');
            $table->string('book_isbn')->nullable();
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowing_details');
        Schema::dropIfExists('borrowings');
    }
};