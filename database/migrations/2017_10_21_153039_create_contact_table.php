<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblContacts', function (Blueprint $table) {
            $table->string('CreditorID');
            $table->integer('ContactID');
            $table->string('ClientName');
            $table->string('Saltnt');
            $table->string('CFirstName');
            $table->string('CLastName');
            $table->boolean('MainManager');
            $table->string('Street');
            $table->string('City');
            $table->string('State');
            $table->string('Zip');
            $table->string('Phone');
            $table->string('Fax');
            $table->string('Ext');
            $table->dateTime('LastUpdate');
            $table->string('UserUpdated');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblContacts');
    }
}
