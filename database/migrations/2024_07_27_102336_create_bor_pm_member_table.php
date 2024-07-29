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
        Schema::create('bor_pm_member', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pro_code', 255);
            $table->string('pro_desc', 255);
            $table->date('p_date1');
            $table->date('p_date2');
            $table->string('p_str_day', 255);
            $table->time('p_time1s');
            $table->time('p_time1e');
            $table->decimal('p_disc1', 8, 2);
            $table->decimal('p_sp_disc1', 8, 2);
            $table->string('pts1', 255);
            $table->string('p_type', 255);
            $table->integer('p_sale1');
            $table->integer('p_free1');
            $table->integer('p_sum1');
            $table->decimal('p_disc_free1', 8, 2);
            $table->integer('p_sale41');
            $table->integer('p_free41');
            $table->string('redule_discount', 1);
            $table->string('fix_branch', 255);
            $table->string('campaign_code', 255);
            $table->integer('psale51');
            $table->decimal('pdiscount51', 8, 2);
            $table->integer('p_quan611');
            $table->decimal('p_disc_per611', 8, 2);
            $table->decimal('p_disc_baht611', 8, 2);
            $table->integer('p_quan612');
            $table->decimal('p_disc_per612', 8, 2);
            $table->decimal('p_disc_baht612', 8, 2);
            $table->integer('p_quan613');
            $table->decimal('p_disc_per613', 8, 2);
            $table->decimal('p_disc_baht613', 8, 2);
            $table->integer('p_quan614');
            $table->decimal('p_disc_per614', 8, 2);
            $table->decimal('p_disc_baht614', 8, 2);
            $table->integer('p_quan615');
            $table->decimal('p_disc_per615', 8, 2);
            $table->decimal('p_disc_baht615', 8, 2);
            $table->decimal('p_amt711', 10, 2);
            $table->decimal('p_disc_per711', 8, 2);
            $table->decimal('p_disc_baht711', 8, 2);
            $table->decimal('p_amt712', 10, 2);
            $table->decimal('p_disc_per712', 8, 2);
            $table->decimal('p_disc_baht712', 8, 2);
            $table->decimal('p_amt713', 10, 2);
            $table->decimal('p_disc_per713', 8, 2);
            $table->decimal('p_disc_baht713', 8, 2);
            $table->decimal('p_amt714', 10, 2);
            $table->decimal('p_disc_per714', 8, 2);
            $table->decimal('p_disc_baht714', 8, 2);
            $table->decimal('p_amt715', 10, 2);
            $table->decimal('p_disc_per715', 8, 2);
            $table->decimal('p_disc_baht715', 8, 2);
            $table->string('brithday', 1);
            $table->string('default_discount', 1);
            $table->string('mudjai_code', 255);
            $table->string('p8type', 1);
            $table->integer('p8qty');
            $table->decimal('p8amount', 10, 2);
            $table->decimal('p9buymin', 10, 2);
            $table->string('p9chkminall', 1);
            $table->string('p9type', 1);
            $table->decimal('p9discountper', 8, 2);
            $table->decimal('p9discountbath', 8, 2);
            $table->string('p9multi', 1);
            $table->string('p9other', 1);
            $table->integer('p9cnt');
            $table->string('protopic', 255);
            $table->text('prodetail');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bor_pm_member');
    }
};
