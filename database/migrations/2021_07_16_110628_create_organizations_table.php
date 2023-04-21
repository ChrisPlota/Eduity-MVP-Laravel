<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->integer('owner_id')->unsigned();
            $table->string('name', 100);
            $table->string('fein')->nullable();
            $table->string('state_id')->nullable();
            $table->string('form')->nullable();
            $table->integer('revenue')->nullable();
            $table->date('date_founded')->nullable();
            $table->text('purpose', 250)->nullable();
            $table->text('description', 1000)->nullable();
            $table->text('trade_name', 100)->nullable();
            $table->string('sector')->nullable();
            $table->text('subsectors')->nullable();
            $table->integer('parent_org_id')->nullable();
            $table->string('website_url')->nullable();
            $table->string('main_phone')->nullable();
            $table->string('main_email')->nullable();
            $table->integer('contact_id')->nullable();
            $table->integer('total_employees')->nullable();
            $table->string('financial_year_ends')->nullable();
            $table->integer('full_time_hours_per_week')->nullable();
            $table->string('business_hours')->nullable();
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('parent_org_id')->references('id')->on('organizations');
            $table->foreign('contact_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
