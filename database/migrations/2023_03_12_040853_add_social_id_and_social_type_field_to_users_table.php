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
        Schema::table('users', function (Blueprint $table) {    // add the below column to "users" table
            $table->string('password')->nullable()->change();    // change password column to nullable
            $table->string('provider_id')->nullable();    // add provider_id column with varchar type
            $table->string('provider')->nullable();  // add provider column with varchar type
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
            $table->dropColumn('provider_id');
            $table->dropColumn('provider');
        });
    }
};
