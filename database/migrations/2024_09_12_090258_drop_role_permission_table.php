<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropRolePermissionTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('role_permission');
    }

    public function down()
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('permission_id');
        });
    }
}
