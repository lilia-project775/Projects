<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('domain_targets', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->decimal('bronze_threshold', 10, 2);
            $table->decimal('silver_threshold', 10, 2);
            $table->decimal('gold_threshold', 10, 2);
            $table->string('unit');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domain_targets');
    }
};
