<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 190);
            $table->string('last_name', 190);
            $table->string('email', 190)->unique();
            $table->bigInteger('owned_by_account_id')->unsigned()->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 190);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            //$table->foreign('owned_by_account_id')->references('id')->on('account');
        });

        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->string('title', 190);
            $table->bigInteger('parent_account_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('primary_user_id')->unsigned()->nullable()->default(null);
            $table->boolean('is_parent')->default(false);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->foreign('parent_account_id')->references('id')->on('account');
            $table->foreign('primary_user_id')->references('id')->on('user');
        });

        Schema::table('user', function (Blueprint $table) {
            $table->bigInteger('owned_by_account_id')->unsigned()->nullable(false)->change();
            $table->foreign('owned_by_account_id')->references('id')->on('account');
        });


        Schema::create('membership', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->foreign('account_id')->references('id')->on('account');
            $table->foreign('user_id')->references('id')->on('user');
        });

        Schema::create('location', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });

        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event');
        Schema::dropIfExists('location');
        Schema::dropIfExists('membership');
        Schema::dropIfExists('user');
        Schema::dropIfExists('account');
    }
}
