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
        Schema::create('customer_tax_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->string('tax_id', 255);
            $table->tinyInteger('is_headoffice')->default(0);
            $table->string('company_name', 255);
            $table->string('branch_no', 255);
            $table->string('company_address', 255);
            $table->string('company_area', 255);
            $table->string('company_subdistrict', 255);
            $table->string('company_district', 255);
            $table->string('company_province', 255);
            $table->string('company_postcode', 255);
            $table->string('company_phone', 255);
            $table->tinyInteger('is_main')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_tax_address');
    }
};
