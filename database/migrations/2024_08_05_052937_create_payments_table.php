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
        Schema::create('payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_name');
            $table->integer('total_data');
            $table->integer('total_benefit');
            $table->date('claim_date');
            $table->enum('status', ['On Progress', 'Completed'])->default('On Progress');
            $table->foreignId('contributor_id')->constrained(table: 'users')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
