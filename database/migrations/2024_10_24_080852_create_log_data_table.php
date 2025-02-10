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
        Schema::create('log_data', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('book_id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('member_id')->references('id')->on('members')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tgl_pinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_data');
    }
};
