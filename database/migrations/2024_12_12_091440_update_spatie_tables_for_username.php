<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSpatieTablesForUsername extends Migration
{
    public function up()
    {
        // Modify model_has_roles
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Add the 'username' column and create an index
            $table->string('username')->index();
        });

        // Modify model_has_permissions
        Schema::table('model_has_permissions', function (Blueprint $table) {
            // Add the 'username' column and create an index
            $table->string('username')->nullable();
        });
    }

    public function down()
    {
        // Revert changes (only drop the 'username' column)
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropColumn('username');
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
}
