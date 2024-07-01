<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 191);
            $table->string('email', 191);
            $table->integer('tipo');
            $table->string('password', 191);
            $table->rememberToken();
            $table->unsignedInteger('empresa_id');

            $table->index(["empresa_id"], 'users_empresa_id_foreign');

            $table->unique(["email"], 'users_email_unique');
            $table->nullableTimestamps();


            $table->foreign('empresa_id', 'users_empresa_id_foreign')
                ->references('id')->on('empresas')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });

        \App\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'tipo' => \App\User::TIPO_ADMIN,
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'empresa_id' => 1
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
