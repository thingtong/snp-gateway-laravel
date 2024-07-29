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
        Schema::create('z_shopping_cart_main', function (Blueprint $table) {
            $table->increments('refmainid');
            $table->integer('custid');
            $table->integer('is_member');
            $table->string('order_mode', 2);
            $table->decimal('deli_fee', 20, 2);
            $table->decimal('pre_amount', 20, 2);
            $table->decimal('discount_member', 20, 2);
            $table->decimal('discount_promotion', 20, 2);
            $table->decimal('discount_special', 20, 2);
            $table->decimal('discount_message', 20, 2);
            $table->decimal('earnest', 20, 2);
            $table->decimal('total_amount', 20, 2);
            $table->string('is_active', 1);
            $table->dateTime('createddate');
            $table->dateTime('modifieddate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('z_shopping_cart_main');
    }
};
