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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('kana');
            $table->string('school_id');
            $table->string('gender')->nullable();
            $table->string('zip')->nullable();
            $table->string('address')->nullable();
            $table->string('tel');
            $table->date('birthday')->nullable();
            $table->date('admission_date');
            $table->date('movein_date')->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('pin_code')->comment('保護者用閲覧制限');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('session_id')->unique();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('children');
    }
};
