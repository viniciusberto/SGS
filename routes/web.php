<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/site/index.php');
});

Route::middleware(['auth'])->resource('dashboard', 'DashboardController');
//Route::middleware(['auth'])->resource('admin', 'DashboardController');

Auth::routes();

Route::middleware(['auth'])->prefix('/admin')->group(function () {
    Route::resource('sla', 'SlaController');
    Route::get('sla/destroy2/{id}', 'SlaController@destroy')->name('sla.destroy2');
    Route::resource('prioridade', 'PrioridadeController');
    Route::get('prioridade/destroy2/{id}', 'PrioridadeController@destroy')->name('prioridade.destroy2');
    Route::resource('empresa', 'EmpresaController');
    Route::get('empresa/destroy2/{id}', 'EmpresaController@destroy')->name('empresa.destroy2');
    Route::resource('usuario', 'UsuarioController');
    Route::get('usuario/destroy2/{id}', 'UsuarioController@destroy')->name('usuario.destroy2');
    Route::resource('dispositivo', 'DispositivoController');
    Route::get('dispositivo/destroy2/{id}', 'DispositivoController@destroy')->name('dispositivo.destroy2');
    Route::resource('produto', 'ProdutoController');
    Route::get('produto/destroy2/{id}', 'ProdutoController@destroy')->name('produto.destroy2');
    Route::resource('chamado', 'ChamadoController');
    Route::get('chamado/destroy2/{id}', 'ChamadoController@destroy')->name('chamado.destroy2');
    Route::get('chamado/listar/{status}', 'ChamadoController@listar')->name('chamado.listar');
    Route::post('chamado/atualizar/{sts}/{id}', 'ChamadoController@atualizar')->name('chamado.atualizar');
    Route::get('chamado/negar/{id}', 'ChamadoController@negarPedido')->name('chamado.negar');
    Route::get('chamado/negar-fechamento/{id}','ChamadoController@negarFechamento')->name('chamado.negar-fechamento');
    Route::get('relatorio/novo','RelatorioController@novo')->name('relatorio.novo');
    Route::post('relatorio/gerar','RelatorioController@gerar')->name('relatorio.gerar');
});
Route::middleware(['auth'])->get('/home', 'DashboardController@index')->name('home');
