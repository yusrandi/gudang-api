<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rekanan_id');
            $table->foreign('rekanan_id')->references('id')->on('rekanans');
            $table->string('spk_file');
            $table->string('spk_no');
            $table->string('spk_date');
            $table->string('spm_file');
            $table->string('spm_no');
            $table->string('spm_date');

            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barangs');
            
            $table->string('barang_price');
            $table->string('barang_qty');
            $table->string('barang_sisa');

            $table->unsignedBigInteger('satuan_id');
            $table->foreign('satuan_id')->references('id')->on('satuans');
            
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
        Schema::dropIfExists('penerimaans');
    }
}
