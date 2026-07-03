<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopsisResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topsis_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
            $table->foreignId('athlete_id')->constrained('athletes')->cascadeOnDelete();
            $table->decimal('preference_value', 12, 6);
            $table->decimal('positive_distance', 12, 6)->nullable();
            $table->decimal('negative_distance', 12, 6)->nullable();
            $table->unsignedInteger('rank');
            $table->json('calculation_detail')->nullable();
            $table->timestamps();

            $table->unique(['period_id', 'athlete_id']);
            $table->unique(['period_id', 'rank']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topsis_results');
    }
}
