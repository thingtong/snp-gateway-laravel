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
        Schema::create('branch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('short_name', 255);
            $table->text('description');
            $table->string('short_description', 255);
            $table->text('address_1');
            $table->text('address_2');
            $table->string('subdistrict', 255);
            $table->string('district', 255);
            $table->string('province', 255);
            $table->string('name_en', 255);
            $table->string('short_name_en', 255);
            $table->text('description_en');
            $table->string('short_description_en', 255);
            $table->text('address_1_en');
            $table->text('address_2_en');
            $table->string('subdistrict_en', 255);
            $table->string('district_en', 255);
            $table->string('province_en', 255);
            $table->string('postcode', 255);
            $table->string('phone_number', 255);
            $table->string('email', 255);
            $table->string('map_latitude', 255);
            $table->string('map_longitude', 255);
            $table->integer('min_eta');
            $table->integer('max_eta');
            $table->json('opening_hour_slots');
            $table->tinyInteger('is_active')->default(1);
            $table->decimal('min_order_price', 10, 2);
            $table->decimal('shipping_cost', 10, 2);
            $table->tinyInteger('accept_cash')->default(1);
            $table->decimal('min_accept_cash', 10, 2);
            $table->tinyInteger('accept_credit')->default(1);
            $table->decimal('min_accept_credit', 10, 2);
            $table->tinyInteger('accept_bank_transfer')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->string('branchcode', 50);
            $table->string('branchcontact', 1000);
            $table->string('branchphone2', 100);
            $table->string('branchphone3', 100);
            $table->date('branchopendate');
            $table->string('branchopen24', 1);
            $table->string('branchopen_mon', 50);
            $table->string('branchclose_mon', 50);
            $table->string('branchopen_tue', 50);
            $table->string('branchclose_tue', 50);
            $table->string('branchopen_wed', 50);
            $table->string('branchclose_wed', 50);
            $table->string('branchopen_thu', 50);
            $table->string('branchclose_thu', 50);
            $table->string('branchopen_fri', 50);
            $table->string('branchclose_fri', 50);
            $table->string('branchopen_sat', 50);
            $table->string('branchclose_sat', 50);
            $table->string('branchopen_sun', 50);
            $table->string('branchclose_sun', 50);
            $table->string('branchmailcc', 2000);
            $table->string('branchmailbcc', 2000);
            $table->dateTime('lastactivedate');
            $table->integer('sortid');
            $table->integer('createduserid');
            $table->string('createdname', 500);
            $table->dateTime('createddate');
            $table->integer('modifieduserid');
            $table->string('modifiedname', 500);
            $table->dateTime('modifieddate');
            $table->string('branchidyum', 200);
            $table->string('branchlat', 50);
            $table->string('branchlong', 50);
            $table->string('branchtierid', 50);
            $table->integer('branchfranid');
            $table->integer('orderid');
            $table->string('sap_site_code', 30);
            $table->string('posserver', 500);
            $table->string('branchdomain', 100);
            $table->string('posstatus', 1);
            $table->integer('setupuserid');
            $table->string('setupname', 500);
            $table->dateTime('setupdate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch');
    }
};
