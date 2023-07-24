<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->default(0)->nullable();
            $table->string('slug')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->string('gender')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('picture')->nullable();
            $table->longText('internal_notes')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
            $table->boolean('do_not_send_cutlery')->nullable()->default(0);
            $table->string('otp')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('token_expired_at')->nullable();
            $table->string('device_type')->nullable()->comment('web, android, ios');
            $table->string('device_token')->nullable();
            $table->string('reset_password_token')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
