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
        
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('phone_number', 255);
            $table->string('title', 255)->nullable();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->dateTime('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('default_locale', ['th', 'en'])->default('th');
            $table->boolean('accepts_terms_and_conditions')->default(false);
            $table->boolean('accepts_marketing_notifications')->default(false);
            $table->tinyInteger('is_member')->default(0);
            $table->tinyInteger('accepts_terms_and_conditions')->default(0);
            $table->tinyInteger('accepts_marketing_notifications')->default(0);
            $table->timestamps();
            $table->string('memberid', 20)->nullable();
            $table->string('custremark', 2000)->nullable();
            $table->string('custphone2', 20)->nullable();
            $table->string('custphone3', 20)->nullable();
            $table->integer('custtypeid')->nullable();
            $table->string('custtypename', 100)->nullable();
            $table->integer('custtitleid')->nullable();
            $table->string('custtitlename', 100)->nullable();
            $table->integer('createduserid')->nullable();
            $table->string('createdname', 100)->nullable();
            $table->dateTime('createddate')->nullable();
            $table->integer('modifieduserid')->nullable();
            $table->string('modifiedname', 100)->nullable();
            $table->dateTime('modifieddate')->nullable();
            $table->dateTime('lastcontactdate')->nullable();
            $table->dateTime('lastorderdate')->nullable();
            $table->string('bankcustid', 500)->nullable();
            $table->string('savecard', 1)->nullable();
            $table->integer('ordercount')->default(0);
            $table->string('mudjaimemberid', 100)->nullable();
            $table->string('mudjaimemberphone', 50)->nullable();
            $table->date('mudjaimemberbirth')->nullable();
            $table->decimal('mudjaimemberpoint', 20, 2)->default(0);
            $table->integer('mudjaimemberactive')->default(0);
            $table->dateTime('mudjaimemberexpire')->nullable();
            $table->dateTime('mudjailastcheckdate')->nullable();
        });
           
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
