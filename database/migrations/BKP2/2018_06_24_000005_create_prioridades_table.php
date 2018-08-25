<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrioridadesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'prioridade';

    /**
     * Run the migrations.
     * @table prioridade
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('descricao', 45)->nullable();
            $table->integer('tempo')->nullable();
            $table->unsignedInteger('sla_id');

            $table->index(["sla_id"], 'fk_prioridades_slas1_idx');


            $table->foreign('sla_id', 'fk_prioridades_slas1_idx')
                ->references('id')->on('slas')
                ->onDelete('no action')
                ->onUpdate('no action');
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
       Schema::dropIfExists($this->set_schema_table);
     }
}
