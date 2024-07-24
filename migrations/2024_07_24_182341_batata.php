<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class Batata extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('batata', function (Blueprint $table) {
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batata', function (Blueprint $table) {
            //
        });
    }
}
