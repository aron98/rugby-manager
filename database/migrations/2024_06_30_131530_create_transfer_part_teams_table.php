<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Team;
use \App\Models\TransferPart;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfer_part_teams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Team::class);
            $table->foreignIdFor(TransferPart::class);
            $table->integer("number_of_people");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_part_teams');
    }
};
