<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suffixes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('suffix')->fulltext();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // add columns for suffix table
            $table->timestamps();
        });

        Schema::create('suffix_group', function (Blueprint $table) {
            $table->foreignId('suffix_id')->constrained()->onDelete('cascade');;
            $table->foreignId('group_id')->constrained()->onDelete('cascade');;
            $table->primary(['suffix_id', 'group_id']);
        });
    }

    public function down()
    {
        // turn off foreign key constraints on the image_group table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('suffixes');
        Schema::dropIfExists('suffix_group');

        // do we have a groups table?
        if(Schema::hasTable('groups')) {
            // is the table empty?
            $isEmpty = DB::table('groups')->doesntExist();
            // do we have a non-suffix type group?
            $hasNonSuffixGroup = DB::table('groups')->where('type', '<>', 'Suffix')->doesntExist();

            // if the table is empty or we don't have a non-suffix type group, drop the table
            if ($hasNonSuffixGroup === null || $isEmpty) {
                Schema::dropIfExists('groups');
            } else {
                // otherwise, delete the images type group
                DB::table('groups')->where('type', 'Suffix')->delete();
            }
        }

        // turn on foreign key constraints on the image_group table
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
