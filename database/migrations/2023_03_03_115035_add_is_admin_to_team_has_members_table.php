<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAdminToTeamHasMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('team_has_members', function (Blueprint $table) {
            $table->tinyInteger('is_admin')->default(0)->comment('0 - no | 1 -yes')->after('team_member_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_has_members', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
}
