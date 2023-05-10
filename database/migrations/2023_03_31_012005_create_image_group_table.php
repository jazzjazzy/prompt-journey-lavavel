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

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Create the pivot table
        Schema::create('image_group', function (Blueprint $table) {
            $table->foreignId('image_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->primary(['image_id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // turn off foreign key constraints on the image_group table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Drop the images and image_group tables
        Schema::dropIfExists('images');
        Schema::dropIfExists('image_group');


        // do we have a groups table?
        if(Schema::hasTable('groups')) {
            // is the table empty?
            $isEmpty = DB::table('groups')->doesntExist();
            // do we have a non-images type group?
            $hasNonImagesGroup = DB::table('groups')->where('type', '<>', 'Image')->doesntExist();

            // if the table is empty or we don't have a non-images type group, drop the table
            if ($hasNonImagesGroup === null || $isEmpty) {
                Schema::dropIfExists('groups');
            } else {
                // otherwise, delete the images type group
                DB::table('groups')->where('type', 'Image')->delete();
            }
        }

        // turn on foreign key constraints on the image_group table
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
