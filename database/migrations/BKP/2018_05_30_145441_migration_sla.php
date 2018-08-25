<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Chamado;

class MigrationSla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->enum('prioridade', array(
                Chamado::PRIORIDADE_NORMAL,
                Chamado::PRIORIDADE_URGENTE,
                Chamado::PRIORIDADE_EMERGENCIA
            ));
            $table->integer('tempo');
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
        Schema::dropIfExists('slas');
    }
}
