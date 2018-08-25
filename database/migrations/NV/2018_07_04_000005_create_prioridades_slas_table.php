<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrioridadesSlasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'prioridades_slas';

    /**
     * Run the migrations.
     * @table prioridades_slas
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('sla_id');
            $table->unsignedInteger('prioridade_id');

            $table->index(["prioridade_id"], 'fk_slas_has_prioridades_prioridades1_idx');

            $table->index(["sla_id"], 'fk_slas_has_prioridades_slas1_idx');
            $table->nullableTimestamps();


            $table->foreign('prioridade_id', 'fk_slas_has_prioridades_prioridades1_idx')
                ->references('id')->on('prioridades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sla_id', 'fk_slas_has_prioridades_slas1_idx')
                ->references('id')->on('slas')
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
