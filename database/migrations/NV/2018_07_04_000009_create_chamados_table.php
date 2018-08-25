<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChamadosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'chamados';

    /**
     * Run the migrations.
     * @table chamados
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('titulo', 191);
            $table->string('descricao', 191)->nullable()->default(null);
            $table->dateTime('data_abertura');
            $table->dateTime('limite_aceitacao')->nullable()->default(null);
            $table->dateTime('data_aceitacao')->nullable()->default(null);
            $table->dateTime('data_fechamento')->nullable()->default(null);
            $table->string('obs', 191)->nullable()->default(null);
            $table->enum('status', ['1', '2', '3', '4', '5', '6', '7']);
            $table->unsignedInteger('equipamento_id');
            $table->unsignedInteger('tecnico_id')->nullable()->default(null);
            $table->unsignedInteger('solicitante_id');
            $table->unsignedInteger('problema_id')->nullable()->default(null);
            $table->unsignedInteger('prioridade_id')->nullable()->default(null);

            $table->index(["tecnico_id"], 'chamados_tecnico_id_foreign');

            $table->index(["solicitante_id"], 'chamados_solicitante_id_foreign');

            $table->index(["equipamento_id"], 'chamados_equipamento_id_foreign');

            $table->index(["problema_id"], 'chamados_problema_id_foreign');

            $table->index(["prioridade_id"], 'fk_chamados_prioridades1_idx');
            $table->nullableTimestamps();


            $table->foreign('equipamento_id', 'chamados_equipamento_id_foreign')
                ->references('id')->on('itens_configuracao')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('problema_id', 'chamados_problema_id_foreign')
                ->references('id')->on('problemas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('solicitante_id', 'chamados_solicitante_id_foreign')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('tecnico_id', 'chamados_tecnico_id_foreign')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('prioridade_id', 'fk_chamados_prioridades1_idx')
                ->references('id')->on('prioridades')
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
