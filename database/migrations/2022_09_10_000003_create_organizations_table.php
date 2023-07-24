<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('identifier')->nullable();
            $table->string('business_type')->nullable();
            $table->string('business_email')->nullable();
            $table->string('civil_id_number')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->integer('users_count')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('attachment')->nullable();
            $table->boolean('is_root_organization')->nullable()->default(0);
            $table->string('currency_code')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
            $table->string('payment_gateway')->nullable();
            $table->string('fatoorah_api_key')->nullable();
            $table->string('u_payments_api_key')->nullable();
            $table->string('sms_uid')->nullable();
            $table->string('sms_account_id')->nullable();
            $table->string('sms_password')->nullable();
            $table->string('sms_sender')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('organizations');
    }
}
