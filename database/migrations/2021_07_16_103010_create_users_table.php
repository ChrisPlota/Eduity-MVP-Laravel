<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('email', 180)->unique();
            $table->string('password', 255);
            $table->string('first_name', 255)->nullable();
            $table->string('middle_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('prior_last_name', 255)->nullable();
            $table->string('prefix', 255)->nullable();
            $table->string('suffix', 255)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('mother_maiden_name', 255)->nullable();
            $table->string('legal_id', 255)->nullable();
            $table->string('driver_license', 255)->nullable();
            $table->string('visa_type', 255)->nullable();
            $table->char('citizenship', 2)->nullable();
            $table->string('miltary_status', 255)->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('ethnicity', 255)->nullable();
            $table->boolean('disability')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->timestamp('lock_expiration_date')->nullable();
            $table->integer('login_attempts')->default(0);
            $table->timestamp('last_login_attempt')->nullable();
            $table->boolean('is_email_confirmed')->default(false);
            $table->string('email_confirmation_code', 255)->nullable();
            $table->string('rest_password_code', 255)->nullable();
            $table->string('unlock_code', 255)->nullable();
            $table->timestamp('reset_password_code_expiration_date')->nullable();
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
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
        Schema::dropIfExists('users');
    }
}
