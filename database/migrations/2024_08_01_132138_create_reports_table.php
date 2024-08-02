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
        Schema::create('reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('latitude', 20);
            $table->string('longitude', 20);
            $table->foreignId('contributor_id')->constrained(table: 'users')->onUpdate('cascade');
            $table->datetime('input_time');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->foreignId('curator_id')->nullable()->constrained(table: 'users')->onUpdate('cascade');
            $table->ulid('claim_id')->nullable();
            $table->datetime('claim_time_start')->nullable();
            $table->datetime('claim_time_end')->nullable();
            $table->datetime('curate_time')->nullable();
            $table->string('curate_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
