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
        Schema::table('users', function (Blueprint $table) {
            // Drop unnecessary columns if they exist
            $table->dropColumn(['name', 'email', 'password', 'email_verified_at']);

            // Check if 'username' column exists before adding it
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique();  // Add the unique username column
            }

            // 'remember_token' and 'timestamps' should already exist, so no need to add them again
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();  // Add remember_token if it doesn't exist
            }

            if (!Schema::hasColumn('users', 'created_at')) {
                $table->timestamps();  // Add created_at and updated_at if they don't exist
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback the changes made in the up() method
        Schema::table('users', function (Blueprint $table) {
            // Add the removed columns back if rolling back the migration
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
        });
    }
};
