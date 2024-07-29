<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWslogHookFromatedateTable extends Migration
{
    public function up()
    {
        // Get current year and month in YYYYMM format
        $tableName = 'zlog_webhook_' . date('Ym');
        Schema::create($tableName, function (Blueprint $table) {
            // $table->bigIncrements('WSLOGID');
            // $table->dateTime('WSLOGDATE');
            // $table->string('WSLOGMODULE', 50);
            // $table->string('WSLOGMODULENAME', 1000);
            // $table->string('WSLOGENDPOINT', 2000);
            // $table->text('WSLOGREQUEST')->nullable();
            // $table->text('WSLOGRESPONSE')->nullable();
            // $table->dateTime('WSREQUESTDATE')->nullable();
            // $table->dateTime('WSRESPONSEDATE')->nullable();
            // $table->integer('WSLOGUSERID');
            // $table->string('WSLOGUSERNAME', 500);
            // $table->string('WSLOGSESSIONID', 200);
            // $table->string('LOCAL_ADDR', 1000);
            // $table->string('LOGON_USER', 1000);
            // $table->string('REMOTE_ADDR', 1000);
            // $table->string('REMOTE_HOST', 1000);
            // $table->string('REMOTE_USER', 1000);
            // $table->string('SERVER_NAME', 1000);
            // $table->string('SERVER_PORT', 1000);
            // $table->string('SERVER_PROTOCAL', 1000);
            // $table->string('SERVER_SOFTWARE', 1000);
            // $table->string('HTTP_HOST', 1000);
            // $table->string('HTTP_USER_AGENT', 1000);
            $table->bigIncrements('wslogid');
            $table->dateTime('wslogdate');
            $table->string('wslogmodule', 50);
            $table->string('wslogmodulename', 1000);
            $table->string('wslogendpoint', 2000);
            $table->text('wslogrequest')->nullable();
            $table->text('wslogresponse')->nullable();
            $table->dateTime('wsrequestdate')->nullable();
            $table->dateTime('wsresponsedate')->nullable();
            $table->integer('wsloguserid');
            $table->string('wslogusername', 500);
            $table->string('wslogsessionid', 200);
            $table->string('local_addr', 1000);
            $table->string('logon_user', 1000);
            $table->string('remote_addr', 1000);
            $table->string('remote_host', 1000);
            $table->string('remote_user', 1000);
            $table->string('server_name', 1000);
            $table->string('server_port', 1000);
            $table->string('server_protocal', 1000);
            $table->string('server_software', 1000);
            $table->string('http_host', 1000);
            $table->string('http_user_agent', 1000);
            $table->timestamps();
        });
    }

    public function down()
    {
        // Get current year and month in YYYYMM format
        $tableName = 'zlog_webhook_' . date('Ym');

        Schema::dropIfExists($tableName);
    }
}
