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
        Schema::table('user_memberships', function (Blueprint $table) {
            $table->string('application_status')->default('pending')->after('status');
            $table->string('photo_url')->nullable()->after('application_status');
            $table->text('application_notes')->nullable()->after('photo_url');
            $table->string('membership_id_number')->nullable()->after('application_notes');
            $table->timestamp('approved_at')->nullable()->after('membership_id_number');
            $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
            $table->text('rejection_reason')->nullable()->after('approved_by');
            $table->timestamp('rejected_at')->nullable()->after('rejection_reason');
            $table->unsignedBigInteger('rejected_by')->nullable()->after('rejected_at');
            
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_memberships', function (Blueprint $table) {
            $table->dropForeign(['approved_by', 'rejected_by']);
            $table->dropColumn([
                'application_status', 'photo_url', 'application_notes', 'membership_id_number',
                'approved_at', 'approved_by', 'rejection_reason', 'rejected_at', 'rejected_by'
            ]);
        });
    }
};
