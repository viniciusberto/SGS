<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Chamado;

class MigrationChamados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('descricao')->nullable(true);
            $table->dateTime('data_abertura');
            $table->dateTime('limite_aceitacao')->nullable(true);
            $table->dateTime('data_aceitacao')->nullable(true);
            $table->dateTime('data_fechamento')->nullable(true);
            $table->string('problema')->nullable(true);
            $table->string('solucao')->nullable(true);
            $table->string('obs')->nullable(true);

            $table->enum('status', array(
                Chamado::STATUS_ANALISE,
                Chamado::STATUS_ABERTO,
                Chamado::STATUS_ACEITO,
                Chamado::STATUS_FECHADO,
                Chamado::STATUS_ANALISE_ACEITACAO,
                Chamado::STATUS_ANALISE_FECHAMENTO,
                Chamado::STATUS_ATENDIMENTO
            ));

            $table->unsignedInteger('equipamento_id');
            $table->foreign('equipamento_id')->references('id')->on('equipamentos')->onDelete('cascade');

            $table->unsignedInteger('tecnico_id')->nullable(true);
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('solicitante_id');
            $table->foreign('solicitante_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('sla_id')->nullable(true);
            $table->foreign('sla_id')->references('id')->on('slas')->onDelete('cascade');


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
        Schema::dropIfExists('chamados');
    }
}
