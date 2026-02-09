<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('green_captain_id')->constrained('users')->cascadeOnDelete();
            $table->string('school_name');
            $table->text('address');
            $table->string('district_region');
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone', 50);
            $table->enum('type', ['Public', 'Private']);
            $table->integer('total_classes');
            $table->string('logo')->nullable();
            $table->string('map_pin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
