<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahKolomUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            if(Schema::hasTable('users')){
                Schema::table('users', function (Blueprint $table) {
                    $table->string('user_id')->after('id');
                    $table->string('nama')->after('user_id');
                    $table->string('username')->after('nama');
                    $table->string('work_center')->after('username');
                    $table->enum('bagian', ['Baku A','Baku B','Baku E','Baku F','Powder dairy','Powder non-dairy','Powder E','Powder F','None','Baku Sentul'])->after('work_center');
                    $table->enum('konfirmasi', ['Y', 'N'])->after('bagian');
                    $table->string('jenis')->after('konfirmasi');
                    $table->string('status')->after('jenis');
                    $table->string('keyword')->after('status');
                    $table->enum('plant', ['ciawi', 'cibitung', 'sentul'])->after('bagian');
                });
            }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
