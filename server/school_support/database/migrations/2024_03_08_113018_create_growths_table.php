<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('growths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('chest', 8, 2)->nullable();
            $table->decimal('abdomen', 8, 2)->nullable();
            $table->decimal('head', 8, 2)->nullable();
            $table->datetime('measurement_month');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('growths');
    }
};
