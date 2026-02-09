<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('green_captain_id')->nullable();
            $table->string('school_name');
            $table->text('address');
            $table->string('district_region');
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone', 50);
            $table->enum('type', ['Public', 'Private']);
            // $table->integer('total_classes');
            $table->string('logo')->nullable();
            // $table->string('map_pin')->nullable();
            $table->timestamps();

            // $table->foreign('green_captain_id')
            //     ->references('id')->on('users')
            //     ->nullOnDelete();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
