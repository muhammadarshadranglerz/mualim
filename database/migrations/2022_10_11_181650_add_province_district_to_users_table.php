<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvinceDistrictToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->string('district')->nullable()->after('email');
            $table->string('province')->nullable()->after('email');
            $table->dropColumn('organization');
            $table->string('instituion')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('district');
            $table->dropColumn('province');
            $table->dropColumn('instituion');
            $table->string('organization')->nullable()->after('email');
        });
    }
}
