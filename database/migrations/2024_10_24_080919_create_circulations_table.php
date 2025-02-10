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
        Schema::create('circulations', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('kode_pinjam');
            $table->foreignId('book_id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('member_id')->references('id')->on('members')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
            // $table->float('denda')->nullable();
            $table->enum('status', ['pinjam', 'kembali']);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circulations');
    }
};
