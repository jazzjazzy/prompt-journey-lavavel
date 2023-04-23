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
        Schema::create('suffixes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('suffix')->fulltext();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // add columns for suffix table
            $table->timestamps();
        });

        Schema::create('suffix_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suffix_id')->constrained()->onDelete('cascade');;
            $table->foreignId('group_id')->constrained()->onDelete('cascade');;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suffixes');
        Schema::dropIfExists('suffix_group');

        $hasNonSuffixGroup = DB::table('groups')->where('type', '<>', 'Suffix')->doesntExist();
        $isEmpty = DB::table('groups')->doesntExist();

        if ($hasNonSuffixGroup === null || $isEmpty) {
            Schema::dropIfExists('groups');
        } else {
            DB::table('groups')->where('type', 'Suffix')->delete();
        }
    }
};
