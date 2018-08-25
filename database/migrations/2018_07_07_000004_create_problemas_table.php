<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'problemas';

    /**
     * Run the migrations.
     * @table problemas
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('descricao', 45)->nullable()->default(null);
            $table->unsignedInteger('solucao_id');

            $table->index(["solucao_id"], 'fk_problemas_solucoes1_idx');
            $table->nullableTimestamps();

            $table->foreign('solucao_id', 'fk_problemas_solucoes1_idx')
                ->references('id')->on('solucoes')
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
