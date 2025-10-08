<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('travel_uuid')->constrained('travels', 'uuid');
            $table->string('name');
            $table->date('startingDate');
            $table->date('endingDate');
            $table->integer('price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
