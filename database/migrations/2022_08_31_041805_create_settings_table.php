<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('google_analytics')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->smallInteger('description_limit')->nullable();
            $table->smallInteger('item_perpage')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->smallInteger('thumb_height')->nullable();
            $table->smallInteger('thumb_width')->nullable();
            $table->smallInteger('image_height')->nullable();
            $table->smallInteger('image_width')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
