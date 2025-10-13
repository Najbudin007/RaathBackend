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
        Schema::table('donations', function (Blueprint $table) {
            $table->unsignedBigInteger('donation_category_id')->nullable()->after('project_id');
            $table->text('donation_purpose')->nullable()->after('message');
            $table->boolean('send_updates')->default(false)->after('is_anonymous');
            $table->string('qr_code')->nullable()->after('transaction_id');
            $table->json('payment_details')->nullable()->after('qr_code');
            
            $table->foreign('donation_category_id')->references('id')->on('donation_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['donation_category_id']);
            $table->dropColumn(['donation_category_id', 'donation_purpose', 'send_updates', 'qr_code', 'payment_details']);
        });
    }
};
