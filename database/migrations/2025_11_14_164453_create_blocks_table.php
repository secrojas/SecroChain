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
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('index');
            $table->json('data'); // Transaction data
            $table->string('previous_hash');
            $table->string('hash');
            $table->unsignedBigInteger('nonce')->default(0);
            $table->foreignId('transaction_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();

            $table->index('index');
            $table->index('hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
