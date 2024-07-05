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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('mark')->nullable();
            $table->string('model')->nullable();
            $table->string('generation')->nullable();
            $table->string('year')->nullable();
            $table->string('run')->nullable();
            $table->string('color')->nullable();
            $table->string('body-type')->nullable();
            $table->string('engine-type')->nullable();
            $table->string('transmission')->nullable();
            $table->string('gear-type')->nullable();
            $table->string('generation_id')->nullable();
            $table->boolean('verified')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
