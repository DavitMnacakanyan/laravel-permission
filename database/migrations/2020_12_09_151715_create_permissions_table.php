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
        Schema::create(config('permissions.tables.permissions'), function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('label')->nullable();

            $table->unique('name');

            $table->timestamps();
        });

        // roles
        Schema::create(config('permissions.tables.roles'), function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('label')->nullable();

            $table->unique('name');

            $table->timestamps();
        });

        // permission_role
        Schema::create(config('permissions.tables.permission_role'), function (Blueprint $table) {
            $table->id();

            $table->foreignId(config('permissions.columns.permission_id'))
                ->constrained(config('permissions.tables.permissions'))
                ->cascadeOnDelete();

            $table->foreignId(config('permissions.columns.role_id'))
                ->constrained(config('permissions.tables.roles'))
                ->cascadeOnDelete();

            $table->unique([
                config('permissions.columns.permission_id'),
                config('permissions.columns.role_id')
            ]);

            $table->timestamps();
        });

        // role_user
        Schema::create(config('permissions.tables.model_has_roles'), function (Blueprint $table) {
            $table->id();

            $table->foreignId(config('permissions.columns.role_id'))
                ->constrained(config('permissions.tables.roles'))
                ->cascadeOnDelete();

            $table->morphs(config('permissions.columns.morphs'));

            $table->unique([
                config('permissions.columns.role_id'),
                config('permissions.columns.morph_key')
            ]);

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
        Schema::dropIfExists(config('permissions.tables.permissions'));
        Schema::dropIfExists(config('permissions.tables.roles'));
        Schema::dropIfExists(config('permissions.tables.permission_role'));
        Schema::dropIfExists(config('permissions.tables.model_has_roles'));
    }
}
