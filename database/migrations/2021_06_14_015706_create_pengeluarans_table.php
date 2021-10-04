<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('penerimaan_id');
            $table->foreign('penerimaan_id')->references('id')->on('penerimaans');

            $table->string('date');
            $table->string('nota_no');
            $table->string('nota_file');
            $table->string('penanggung');
            $table->string('penerima');

            $table->string('qty');
            $table->string('sisa');

            $table->unsignedBigInteger('bagian_id');
            $table->foreign('bagian_id')->references('id')->on('bagians');
            
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
        Schema::dropIfExists('pengeluarans');
    }
}
