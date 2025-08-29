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
        Schema::table('membership_plans', function (Blueprint $table) {
            $table->string('tier_name')->nullable()->after('name');
            $table->string('color_theme')->nullable()->after('tier_name');
            $table->json('detailed_benefits')->nullable()->after('benefits');
            $table->string('seating_priority')->nullable()->after('detailed_benefits');
            $table->string('annual_kit_type')->nullable()->after('seating_priority');
            $table->string('newsletter_frequency')->nullable()->after('annual_kit_type');
            $table->string('events_access')->nullable()->after('newsletter_frequency');
            $table->string('certificate_type')->nullable()->after('events_access');
            $table->boolean('is_volunteer_based')->default(false)->after('certificate_type');
            $table->integer('sort_order')->default(0)->after('is_volunteer_based');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_plans', function (Blueprint $table) {
            $table->dropColumn([
                'tier_name', 'color_theme', 'detailed_benefits', 'seating_priority',
                'annual_kit_type', 'newsletter_frequency', 'events_access', 
                'certificate_type', 'is_volunteer_based', 'sort_order'
            ]);
        });
    }
};
