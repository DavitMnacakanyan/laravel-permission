<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('label')->nullable();

            $table->unique('name');

            $table->timestamps();
        });

        // roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('label')->nullable();

            $table->unique('name');

            $table->timestamps();
        });

        // permission_role
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();

            $table->foreignId('permission_id')
                ->constrained('permissions')
                ->cascadeOnDelete();

            $table->foreignId('role_id')
                ->constrained('roles')
                ->cascadeOnDelete();

            $table->unique(['permission_id', 'role_id']);

            $table->timestamps();
        });

        // role_user
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')
                ->constrained('roles')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unique(['role_id', 'user_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
    }
}
