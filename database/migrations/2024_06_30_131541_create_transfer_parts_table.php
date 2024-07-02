<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Place;
use \App\Models\Transfer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfer_parts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Place::class, "from");
            $table->foreignIdFor(Place::class, "to");
            $table->dateTime("begin");
            $table->dateTime("end");
            $table->foreignIdFor(Transfer::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_parts');
    }
};
