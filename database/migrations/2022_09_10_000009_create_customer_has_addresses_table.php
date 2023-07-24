<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerHasAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_has_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->unsignedInteger('customer_id')->default(0)->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('block')->nullable();
            $table->string('street')->nullable();
            $table->string('house_name')->nullable();
            $table->string('avenue')->nullable();
            $table->string('floor')->nullable();
            $table->string('flat')->nullable();
            $table->string('landmark')->nullable();
            $table->boolean('is_default')->nullable()->default(0);
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('customer_has_addresses');
    }
}
