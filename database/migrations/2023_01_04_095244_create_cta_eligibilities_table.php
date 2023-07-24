<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCtaEligibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cta_eligibilities', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('profession', ['Business Owner',' Tax Professional','Beneficial Owner'])->comment('1 - Business Owner | 2 - Tax Professional | 3 - Beneficial Owner')->nullable();
            $table->string('company_name')->nullable();
            $table->string('entity_name')->nullable();
            $table->enum('gross_revenue', ['Business Owner',' Tax Professional','Beneficial Owner'])->comment('1 - Business Owner | 2 - Tax Professional | 3 - Beneficial Owner')->nullable();
            $table->string('company_website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('status')->default(1)->comment('1 - active | 2 - deactive ')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('cta_eligibilities');
    }
}
