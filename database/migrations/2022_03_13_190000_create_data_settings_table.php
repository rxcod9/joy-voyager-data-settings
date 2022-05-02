<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->bigInteger('data_id')->unsigned();
            // $table->foreign('data_id')->references('id')->on('datas');

            $table->integer('data_setting_type_id')->unsigned();
            $table->foreign('data_setting_type_id')->references('id')->on('data_setting_types');

            $table->text('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_settings');
    }
}
