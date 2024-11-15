<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    if (!Schema::hasTable('users')) {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); // Remove "after" clause
            $table->string('email')->unique();    // Remove "after" clause
            $table->unsignedBigInteger('id_role'); // Remove "after" clause
            $table->string('password');           // Remove "after" clause
            $table->timestamps();
        });        
    }
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('nama');
    });
}

};
