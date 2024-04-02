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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_class_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('subject_id_first')->nullable()->constrained('subjects')->onDelete('set null');
            $table->unsignedBigInteger('subject_id_second')->nullable()->constrained('subjects')->onDelete('set null');
            $table->unsignedBigInteger('subject_id_third')->nullable()->constrained('subjects')->onDelete('set null');
            $table->unsignedBigInteger('subject_id_fourth')->nullable()->constrained('subjects')->onDelete('set null');
            $table->unsignedBigInteger('subject_id_five')->nullable()->constrained('subjects')->onDelete('set null');
            $table->unsignedBigInteger('subject_id_six')->nullable()->constrained('subjects')->onDelete('set null');
            $table->unsignedBigInteger('subject_id_other')->nullable()->constrained('subjects')->onDelete('set null');
            $table->unsignedBigInteger('subject_id_all_check')->nullable()->constrained('subjects')->onDelete('set null');
            $table->date('schedule_date');
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
        Schema::dropIfExists('schedules');
    }
};
