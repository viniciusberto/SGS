<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProdutosChamados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_chamados', function (Blueprint $table) {

            $table->unsignedInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');

            $table->unsignedInteger('chamado_id');
            $table->foreign('chamado_id')->references('id')->on('chamados')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('produtos_chamados');
    }
}
