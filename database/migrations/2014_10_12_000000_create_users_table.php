<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Pastikan ekstensi UUID tersedia di PostgreSQL
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        
        // Buat tabel users dengan id UUID
        Schema::create('users', function (Blueprint $table) {
            // Ubah tipe data menjadi UUID
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role')->default('kasir');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}; 