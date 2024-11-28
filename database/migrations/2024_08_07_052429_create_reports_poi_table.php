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
            $table->string('location_info')->nullable();
            $table->string('location_name');
            $table->string('location_name_update')->nullable();
            $table->string('street_name')->nullable();
            $table->string('building_number')->nullable();
            $table->string('category')->nullable();
            $table->string('latitude', 20);
            $table->string('longitude', 20);
            $table->string('image_path');
            $table->string('img_latitude', 20)->nullable();
            $table->string('img_longitude', 20)->nullable();
            $table->string('img_altitude', 20)->nullable();
            $table->datetime('img_time')->nullable();
            $table->datetime('input_time');
            $table->string('new_latitude', 20)->nullable();
            $table->string('new_longitude', 20)->nullable();
            $table->ulid('claim_id')->nullable();
            $table->datetime('claim_time_start')->nullable();
            $table->datetime('claim_time_end')->nullable();
            $table->datetime('curate_time')->nullable();
            $table->foreignId('contributor_id')->constrained(table: 'users')->onUpdate('cascade');
            $table->foreignId('curator_id')->nullable()->constrained(table: 'users')->onUpdate('cascade');
            $table->foreignUlid('payment_id')->nullable()->constrained(table: 'payments')->onUpdate('cascade');
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
