<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('skill_user', function (Blueprint $table) {
            $table->id();
          
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('skill_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('skill_id')->references('id')->on('skills');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('skill_user', function (Blueprint $table) {
            
            $table->dropColumn('user_id');
            $table->dropColumn('skill_id');
          
            $table->dropForeign(['user_id']);
            $table->dropForeign(['skill_id']);
        });

        Schema::dropIfExists('skill_user');

        
        
    }
};
