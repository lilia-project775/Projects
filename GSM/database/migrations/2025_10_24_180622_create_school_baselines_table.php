<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('school_baselines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->decimal('water_usage_liters', 10, 2);
            $table->decimal('energy_usage_kwh', 10, 2);
            $table->decimal('waste_generated_kg', 10, 2);
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_baselines');
    }
};
