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
        Schema::table('projects', function (Blueprint $table) {
            $table->text('vision')->nullable()->after('short_description');
            $table->text('technical_specs')->nullable()->after('vision');
            $table->json('design_docs')->nullable()->after('technical_specs');
            $table->decimal('budget', 10, 2)->nullable()->after('collected_amount');
            $table->enum('status', ['active', 'completed', 'cancelled', 'planning'])->default('planning')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['vision', 'technical_specs', 'design_docs', 'budget']);
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active')->change();
        });
    }
};
