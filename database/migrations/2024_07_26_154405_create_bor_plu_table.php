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
        Schema::create('bor_plu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255);
            $table->string('barcode', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('referent_code', 255)->nullable();
            $table->string('unit', 255)->nullable();
            $table->string('storage_location', 255)->nullable();
            $table->string('product_type', 255)->nullable();
            $table->string('discount', 255)->nullable();
            $table->string('tax_calculation', 255)->nullable();
            $table->string('product_category', 255)->nullable();
            $table->string('product_set', 255)->nullable();
            $table->string('pricing_method', 255)->nullable();
            $table->string('stock_management', 255)->nullable();
            $table->string('kitchen_printing', 255)->nullable();
            $table->string('service_charge', 255)->nullable();
            $table->string('product_group_code', 255)->nullable();
            $table->string('vendor_code', 255)->nullable();
            $table->string('price_eat_in', 255)->nullable();
            $table->string('price_take_away', 255)->nullable();
            $table->string('price_delivery', 255)->nullable();
            $table->string('price_pinto', 255)->nullable();
            $table->string('price_wholesale', 255)->nullable();
            $table->string('promotion1', 255)->nullable();
            $table->string('promotion2', 255)->nullable();
            $table->string('promotion3', 255)->nullable();
            $table->string('not_use1', 255)->nullable();
            $table->string('not_use2', 255)->nullable();
            $table->string('standard_cost', 255)->nullable();
            $table->string('average_cost', 255)->nullable();
            $table->string('latest_cost', 255)->nullable();
            $table->text('remark')->nullable();
            $table->string('not_use3', 255)->nullable();
            $table->string('active', 255)->nullable();
            $table->string('not_use4', 255)->nullable();
            $table->date('last_update')->nullable();
            $table->string('department_charge', 255)->nullable();
            $table->string('personal_charge', 255)->nullable();
            $table->string('special_charge', 255)->nullable();
            $table->string('selectable_set_item', 255)->nullable();
            $table->string('selectable_item_count', 255)->nullable();
            $table->string('not_use5', 255)->nullable();
            $table->string('preparation_time', 255)->nullable();
            $table->string('not_use6', 255)->nullable();
            $table->text('kitchen_print_description')->nullable();
            $table->string('short_description', 255)->nullable();
            $table->string('not_use7', 255)->nullable();
            $table->string('not_use8', 255)->nullable();
            $table->string('flag', 255)->nullable();
            $table->string('sap_article', 255)->nullable();
            $table->string('sap_article_name', 255)->nullable();
            $table->string('sap_article_barcode', 255)->nullable();
            $table->string('sap_article_unit', 255)->nullable();
            $table->string('ap_article_jde', 255)->nullable();
            $table->string('sap_article_active', 255)->nullable();
            $table->time('wtime')->nullable();
            $table->time('ltime')->nullable();
            $table->text('description_english')->nullable();
            $table->string('daily_count_stock', 255)->nullable();
            $table->string('weekly_count_stock', 255)->nullable();
            $table->string('monthly_count_stock', 255)->nullable();
            $table->string('show_for_stock_count', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bor_plu');
    }
};
