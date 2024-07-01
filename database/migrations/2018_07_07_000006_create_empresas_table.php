<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'empresas';

    /**
     * Run the migrations.
     * @table empresas
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nome', 191);
            $table->string('cnpj', 191);
            $table->string('endereco', 191);
            $table->string('telefone', 191);
            $table->string('ie', 191);
            $table->unsignedInteger('sla_id');

            $table->index(["sla_id"], 'fk_empresas_slas1_idx');

            $table->unique(["cnpj"], 'empresas_cnpj_unique');
            $table->nullableTimestamps();


            $table->foreign('sla_id', 'fk_empresas_slas1_idx')
                ->references('id')->on('slas')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        \App\Empresa::create([
            'nome' => 'Empresa 1',
            'cnpj' => '12345678901234',
            'endereco' => 'Rua 1, 123',
            'telefone' => '1234567890',
            'ie' => '1234567890',
            'sla_id' => 1
        ]);
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
