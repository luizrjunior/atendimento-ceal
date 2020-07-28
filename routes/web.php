<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * ACL
 */
Route::resource('users', 'Acl\UserController');

Route::resource('roles', 'Acl\RoleController');

Route::resource('permissions', 'Acl\PermissionController');

Route::post('user-has-role/store', 'Acl\UserHasRoleController@store')->name('users.store-user-has-role');
Route::delete('user-has-role/destroy', 'Acl\UserHasRoleController@destroy')->name('users.destroy-user-has-role');

Route::post('role-has-permission/store', 'Acl\RoleHasPermissionController@store')->name('roles.store-role-has-permission');
Route::post('role-has-permission/load-permissions-role-json', 'Acl\RoleHasPermissionController@loadPermissionsRoleJson')->name('roles.load-permissions-role-json');
Route::delete('role-has-permission/destroy', 'Acl\RoleHasPermissionController@destroy')->name('roles.destroy-role-has-permission');

/**
 * CADASTROS
 */
Route::resource('funcoes', 'Cadastros\FuncaoController');
Route::post('funcoes/ativar-desativar-funcao', 'Cadastros\FuncaoController@ativarDesativarFuncao');

Route::resource('locais', 'Cadastros\LocalController');
Route::post('locais/ativar-desativar-local', 'Cadastros\LocalController@ativarDesativarLocal');

Route::resource('horarios', 'Cadastros\HorarioController');
Route::post('horarios/ativar-desativar-horario', 'Cadastros\HorarioController@ativarDesativarHorario');

Route::resource('motivos', 'Cadastros\MotivoController');
Route::post('motivos/ativar-desativar-motivo', 'Cadastros\MotivoController@ativarDesativarMotivo');

Route::resource('orientacoes', 'Cadastros\OrientacaoController');
Route::post('orientacoes/ativar-desativar-orientacao', 'Cadastros\OrientacaoController@ativarDesativarOrientacao');

Route::resource('atividades', 'Cadastros\AtividadeController');
Route::post('atividades/ativar-desativar-atividade', 'Cadastros\AtividadeController@ativarDesativarAtividade');

Route::resource('participantes', 'Cadastros\ParticipanteController');
Route::post('participantes/ativar-desativar-participante', 'Cadastros\ParticipanteController@ativarDesativarParticipante');

/**
 * PESSOAS
 */
Route::resource('pessoas', 'Pessoas\PessoaController');
Route::post('pessoas/carregar-pessoa-cpf', 'Pessoas\PessoaController@carregarPessoaPorCPF')->name('pessoas.carrregar-pessoa-cpf');

Route::resource('colaboradores', 'Pessoas\ColaboradorController');
Route::post('colaboradores/ativar-desativar-colaborador', 'Pessoas\ColaboradorController@ativarDesativarColaborador');
