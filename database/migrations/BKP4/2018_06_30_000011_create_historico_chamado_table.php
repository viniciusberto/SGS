<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoChamadoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'historico_chamado';

    /**
     * Run the migrations.
     * @table historico_chamado
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('chamados_id');
            $table->string('descricao', 45)->nullable();
            $table->dateTime('data')->nullable();
            $table->string('historico_chamadocol', 45)->nullable();

            $table->index(["chamados_id"], 'fk_historico_chamado_chamados1_idx');


            $table->foreign('chamados_id', 'fk_historico_chamado_chamados1_idx')
                ->references('id')->on('chamados')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
