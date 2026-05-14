<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flavor_restaurant', function (Blueprint $table) {
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('flavor_id')->constrained()->cascadeOnDelete();
            $table->primary(['restaurant_id', 'flavor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flavor_restaurant');
    }
};
