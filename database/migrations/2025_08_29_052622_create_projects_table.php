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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description');
            $table->text('vision')->nullable();
            $table->text('technical_specs')->nullable();
            $table->json('design_docs')->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->decimal('target_amount', 10, 2);
            $table->decimal('collected_amount', 10, 2)->default(0);
            $table->decimal('budget', 10, 2)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'completed', 'cancelled', 'planning'])->default('planning');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
