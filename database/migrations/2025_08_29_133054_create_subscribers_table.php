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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('city')->nullable();
            $table->string('membership_status')->nullable(); // member, non_member, etc.
            $table->boolean('whatsapp_opt_in')->default(false);
            $table->boolean('email_opt_in')->default(true);
            $table->enum('status', ['active', 'inactive', 'unsubscribed'])->default('active');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_token')->nullable();
            $table->json('preferences')->nullable(); // Newsletter preferences, categories of interest, etc.
            $table->timestamps();
            
            $table->index(['status', 'email_opt_in']);
            $table->index(['city', 'status']);
            $table->index('whatsapp_opt_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
