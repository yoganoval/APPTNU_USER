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
        Schema::create('certificate_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_template_id')->constrained()->onDelete('cascade');

            $table->string('field_name'); 
            // contoh: name, event, date, number

            $table->integer('x'); // posisi horizontal
            $table->integer('y'); // posisi vertikal

            $table->integer('font_size')->default(24);
            $table->string('font_color')->default('#000000');

            $table->string('font_weight')->default('normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_fields');
    }
};
