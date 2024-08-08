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
        Schema::create('reports_poi', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('reject_reason')->nullable();
            $table->string('location_name');
            $table->string('location_address')->nullable();
            $table->string('category')->nullable();
            $table->string('latitude', 20);
            $table->string('longitude', 20);
            $table->string('image_path');
            $table->datetime('input_time');
            $table->ulid('claim_id')->nullable();
            $table->datetime('claim_time_start')->nullable();
            $table->datetime('claim_time_end')->nullable();
            $table->datetime('curate_time')->nullable();
            $table->foreignId('contributor_id')->constrained(table: 'users')->onUpdate('cascade');
            $table->foreignId('curator_id')->nullable()->constrained(table: 'users')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports_poi');
    }
};
