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
        Schema::create('reports_pa', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('reject_reason')->nullable();
            $table->string('street_name')->nullable();
            $table->string('street_name_status')->nullable();
            $table->string('house_number')->nullable();
            $table->string('house_number_status')->nullable();
            $table->string('house_number_update')->nullable();
            $table->string('latitude', 20);
            $table->string('longitude', 20);
            $table->foreignId('curator_id')->nullable()->constrained(table: 'users')->onUpdate('cascade');
            $table->ulid('claim_id')->nullable();
            $table->datetime('claim_time_start')->nullable();
            $table->datetime('claim_time_end')->nullable();
            $table->datetime('curate_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports_pa');
    }
};
