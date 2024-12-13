<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUsernameFromSpatieTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the 'username' column from model_has_roles table
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropColumn('username');
        });

        // Drop the 'username' column from model_has_permissions table
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // You can optionally add the 'username' columns back if you need to revert this migration
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->string('username')->index();  // Adding the column back if needed
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->string('username')->nullable();  // Adding the column back if needed
        });
    }
}
