<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penerimaan_id')->nullable();
            $table->foreign('penerimaan_id')->references('id')->on('penerimaans');

            $table->unsignedBigInteger('pengeluaran_id')->nullable();
            $table->foreign('pengeluaran_id')->references('id')->on('pengeluarans');
            
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')->references('id')->on('barangs');

            $table->string('qty');
            $table->string('sisa');

            $table->integer('status')->default(1);
            $table->string('date');
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
        Schema::dropIfExists('reports');
    }
}
