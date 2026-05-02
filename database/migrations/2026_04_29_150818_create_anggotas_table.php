<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('wilayah')->nullable();
            $table->string('jenis_perpustakaan')->nullable();
            $table->string('id_anggota')->nullable();

            $table->string('nama_perguruan_tinggi')->nullable();
            $table->string('nama_perpustakaan');

            $table->text('alamat')->nullable();

            $table->string('email_perpustakaan')->nullable();
            $table->string('telp')->nullable();
            $table->string('fax')->nullable();

            $table->string('nama_kepala')->nullable();
            $table->string('email_kepala')->nullable();
            $table->string('wa_kepala')->nullable();

            $table->string('nama_pic')->nullable();
            $table->string('wa_pic')->nullable();

            $table->string('website')->nullable();
            $table->string('repository')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('blog')->nullable();

            $table->string('logo')->nullable();
            $table->string('surat')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};