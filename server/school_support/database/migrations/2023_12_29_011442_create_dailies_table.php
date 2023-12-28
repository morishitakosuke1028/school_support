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
        Schema::create('dailies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained();
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();
            $table->string('attendance_status')->nullable();
            $table->string('absence_reason')->nullable();
            $table->text('admin_memo')->nullable();
            $table->text('parent_memo')->nullable();
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
        Schema::dropIfExists('dailies');
    }
};
