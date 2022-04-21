<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asets', function (Blueprint $table) {
            $table->string('id_aset')->unique();
            $table->string('id_kategori');
            $table->string('nama_aset');
            $table->string('gedung');
            $table->string('ruangan');
            $table->string('kondisi');
            $table->string('keterangan')->nullable();

            $table->string('edited_by')->nullable();
            $table->string('jenis_pindah')->nullable();

            $table->double('harga_beli', 10, 2)->default(0);
            $table->double('harga_jual', 10, 2)->nullable();
            
            $table->string('foto_aset')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('asets');
    }
}
