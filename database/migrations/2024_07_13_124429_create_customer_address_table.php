<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->string('type', 255);
            $table->string('address_label', 255);
            $table->string('building_name', 255)->nullable();
            $table->string('room_number', 255)->nullable();
            $table->string('floor_number', 255)->nullable();
            $table->string('address1', 255);
            $table->string('address2', 255)->nullable();
            $table->string('province', 255);
            $table->string('district', 255);
            $table->string('subdistrict', 255);
            $table->string('city', 255);
            $table->string('postcode', 255);
            $table->boolean('is_verified')->default(0);
            $table->string('latitude', 255)->nullable();
            $table->string('longitude', 255)->nullable();
            $table->string('directions', 255)->nullable();
            $table->integer('area_id')->nullable();
            $table->string('geolocation_source', 255)->nullable();
            $table->string('formatted', 255)->nullable();
            $table->string('distance', 255)->nullable();
            $table->text('note')->nullable();
            $table->string('name', 255);
            $table->string('phone_number', 255);
            $table->boolean('is_main')->default(0);
            $table->timestamps();
            $table->string('branchmain1', 10)->nullable();
            $table->string('branchmain1name', 200)->nullable();
            $table->string('branchsub1', 10)->nullable();
            $table->string('branchsub1name', 200)->nullable();
            $table->integer('createduserid')->nullable();
            $table->string('createdname', 100)->nullable();
            $table->dateTime('createddate')->nullable();
            $table->integer('modifieduserid')->nullable();
            $table->string('modifiedname', 100)->nullable();
            $table->dateTime('modifieddate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_address');
    }
};
