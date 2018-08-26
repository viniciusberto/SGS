<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensConfiguracaoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'itens_configuracao';

    /**
     * Run the migrations.
     * @table itens_configuracao
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('descricao', 191);
            $table->unsignedInteger('empresa_id');

            $table->index(["empresa_id"], 'fk_itens_configuracao_empresas1_idx');
            $table->nullableTimestamps();


            $table->foreign('empresa_id', 'fk_itens_configuracao_empresas1_idx')
                ->references('id')->on('empresas')
                ->onDelete('cascade')
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
