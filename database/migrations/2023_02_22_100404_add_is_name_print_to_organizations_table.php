<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsNamePrintToOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->boolean('is_name_print')->nullable()->after('is_time_print')->default(1);
            $table->time('start_time')->nullable()->after('attachment')->default('09:00:00');
            $table->time('end_time')->nullable()->after('start_time')->default('23:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('is_name_print');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }
}
