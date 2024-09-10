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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->unsignedBigInteger('created_by')->nullable(); // Kolom userstamps
            $table->unsignedBigInteger('updated_by')->nullable(); // Kolom userstamps
            $table->unsignedBigInteger('deleted_by')->nullable(); // Kolom userstamps
            $table->timestamps();
            $table->softDeletes();

            // Menambahkan foreign key constraints jika ada tabel users
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
