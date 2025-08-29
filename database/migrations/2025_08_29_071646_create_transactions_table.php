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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('transaction_id')->unique(); // External transaction ID
            $table->string('type'); // order, membership, donation
            $table->string('reference_type')->nullable(); // Order, UserMembership, Donation
            $table->unsignedBigInteger('reference_id')->nullable(); // ID of the related model
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method'); // online, cash, bank_transfer, etc.
            $table->string('payment_gateway')->nullable(); // stripe, paypal, etc.
            $table->json('gateway_response')->nullable(); // Response from payment gateway
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Additional transaction data
            $table->timestamps();
            
            $table->index(['user_id', 'type']);
            $table->index(['reference_type', 'reference_id']);
            $table->index(['status', 'created_at']);
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
