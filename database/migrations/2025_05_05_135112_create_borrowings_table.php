<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id('borrowing_id'); // Primary key
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('borrow_date');
            $table->dateTime('due_date')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->enum('status', ['borrowed', 'returned'])->default('borrowed');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
