<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosChamadosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'produtos_chamados';

    /**
     * Run the migrations.
     * @table produtos_chamados
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('produto_id');
            $table->unsignedInteger('chamado_id');

            $table->index(["produto_id"], 'produtos_chamados_produto_id_foreign');

            $table->index(["chamado_id"], 'produtos_chamados_chamado_id_foreign');


            $table->foreign('chamado_id', 'produtos_chamados_chamado_id_foreign')
                ->references('id')->on('chamados')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('produto_id', 'produtos_chamados_produto_id_foreign')
                ->references('id')->on('produtos')
                ->onDelete('cascade')
                ->onUpdate('restrict');
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
