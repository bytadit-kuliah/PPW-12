<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_kategoris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangs_id');
            $table->unsignedBigInteger('kategoris_id');

            $table->foreign('barangs_id')->references('id')->on('barangs');
            $table->foreign('kategoris_id')->references('id')->on('kategoris');
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
        Schema::dropIfExists('barang_kategoris');
    }
};
