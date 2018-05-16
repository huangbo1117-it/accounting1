<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblcreditors', function (Blueprint $table) {
            $table->string('CreditorID');
            $table->integer('SaleID');
            $table->date('OpenDate');
            $table->text('Comments');
            $table->boolean('CompReport');
            $table->date('LastDate');
            $table->date('LastUpdate');
            $table->integer('UserUpdated');
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
        Schema::dropIfExists('tblCreditors');
    }
}
