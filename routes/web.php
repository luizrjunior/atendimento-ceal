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

Route::get('/my-profile', 'Acl\MyProfileController@edit')->name('my-profile');
Route::post('/my-profile/update', 'Acl\MyProfileController@update')->name('my-profile.update');
Route::post('/my-profile/update-password', 'Acl\MyProfileController@updatePassword')->name('my-profile.update-password');

/**
 * CADASTROS
 */

/**
 * FUNCOES
 */
Route::resource('funcoes', 'Cadastros\FuncaoController');
Route::post('funcoes/ativar-desativar-funcao', 'Cadastros\FuncaoController@ativarDesativarFuncao');

/**
 * LOCAIS
 */
Route::resource('locais', 'Cadastros\LocalController');
Route::post('locais/ativar-desativar-local', 'Cadastros\LocalController@ativarDesativarLocal');

/**
 * HORARIOS
 */
Route::resource('horarios', 'Cadastros\HorarioController');
Route::post('horarios/ativar-desativar-horario', 'Cadastros\HorarioController@ativarDesativarHorario');
Route::post('horarios/carregar-horarios-atividade-json', 'Cadastros\HorarioController@carregarHorariosAtividadeJson')->name('horarios.carregar-horarios-atividade-json');

/**
 * ROTAS DO CADASTRO DE HORARIOS QUE SERVEM NA HORA DE REGISTRAR UM ATENDIMENTO
 */
Route::post('horarios/listar-horarios-por-atividade', 'Cadastros\HorarioController@listarHorariosPorAtividade')->name('horarios.listar-horarios-por-atividade');

/**
 * MOTIVOS
 */
Route::resource('motivos', 'Cadastros\MotivoController');
Route::post('motivos/ativar-desativar-motivo', 'Cadastros\MotivoController@ativarDesativarMotivo');

Route::resource('orientacoes', 'Cadastros\OrientacaoController');
Route::post('orientacoes/ativar-desativar-orientacao', 'Cadastros\OrientacaoController@ativarDesativarOrientacao');

Route::resource('atividades', 'Cadastros\AtividadeController');
Route::post('atividades/ativar-desativar-atividade', 'Cadastros\AtividadeController@ativarDesativarAtividade');

/**
 * PARTICIPANTES
 */
Route::get('participantes', 'Cadastros\ParticipanteController@index')->name('participantes.index');

Route::get('participantes/create', 'Cadastros\ParticipanteController@create')->name('participantes.create');
Route::post('participantes/store', 'Cadastros\ParticipanteController@store')->name('participantes.store');

Route::get('participantes/{horario_id}/edit', 'Cadastros\ParticipanteController@edit')->name('participantes.edit');
Route::post('participantes/remover-participante', 'Cadastros\ParticipanteController@destroy')->name('participantes.destroy');

Route::any('participantes/search', 'Cadastros\ParticipanteController@search')->name('participantes.search');

/**
 * PESSOAS
 */
Route::resource('pessoas', 'Pessoas\PessoaController');
Route::post('pessoas/carregar-pessoa-cpf', 'Pessoas\PessoaController@carregarPessoaPorCPF')->name('pessoas.carrregar-pessoa-cpf');

/**
 * PESSOAS-ADMIN
 */
Route::any('pessoas-admin', 'Pessoas\PessoaAdminController@index')->name('pessoas.admin.index');

Route::get('pessoas-admin/{pessoa_id}/edit', 'Pessoas\PessoaAdminController@edit')->name('pessoas.admin.edit');
Route::patch('pessoas-admin/{pessoa_id}', 'Pessoas\PessoaAdminController@update')->name('pessoas.admin.update');

/**
 * COLABORADORES
 */
Route::any('colaboradores', 'Pessoas\ColaboradorController@index')->name('colaboradores.index');

Route::get('colaboradores/create', 'Pessoas\ColaboradorController@create')->name('colaboradores.create');
Route::post('colaboradores/store', 'Pessoas\ColaboradorController@store')->name('colaboradores.store');

Route::get('colaboradores/{colaborador_id}/edit', 'Pessoas\ColaboradorController@edit')->name('colaboradores.edit');
Route::patch('colaboradores/update', 'Pessoas\ColaboradorController@update')->name('colaboradores.update');

Route::post('colaboradores/ativar-desativar-colaborador', 'Pessoas\ColaboradorController@ativarDesativarColaborador');

/**
 * ATENDIMENTOS
 */
Route::resource('atendimentos', 'Atendimentos\AtendimentoController');
Route::post('atendimentos/abrir-create', 'Atendimentos\AtendimentoController@abrirCreate')->name('atendimentos.abrir-create');

/**
 * ATENDIMENTOS-ADMIN
 */
Route::any('atendimentos-admin', 'Atendimentos\AtendimentoAdminController@index')->name('atendimentos-admin.index');

Route::get('atendimentos-admin/create', 'Atendimentos\AtendimentoAdminController@create')->name('atendimentos-admin.create');
Route::post('atendimentos-admin/store', 'Atendimentos\AtendimentoAdminController@store')->name('atendimentos-admin.store');

Route::get('atendimentos-admin/{atendimento_id}/edit', 'Atendimentos\AtendimentoAdminController@edit')->name('atendimentos-admin.edit');
Route::patch('atendimentos-admin/{atendimento_id}', 'Atendimentos\AtendimentoAdminController@update')->name('atendimentos-admin.update');

Route::post('atendimento-has-motivo/store', 'Atendimentos\AtendimentoHasMotivoController@store')->name('atendimentos.store-atendimento-has-motivo');
Route::post('atendimento-has-motivo/load-motivos-atendimento-json', 'Atendimentos\AtendimentoHasMotivoController@loadMotivosAtendimentoJson')->name('atendimentos.load-motivos-atendimento-json');

Route::post('atendimento-has-orientacao/store', 'Atendimentos\AtendimentoHasOrientacaoController@store')->name('atendimentos.store-atendimento-has-orientacao');
Route::post('atendimento-has-orientacao/load-orientacoes-atendimento-json', 'Atendimentos\AtendimentoHasOrientacaoController@loadOrientacoesAtendimentoJson')->name('atendimentos.load-orientacoes-atendimento-json');

Route::post('atendimentos-admin/salvar-orientacoes-atendimento', 'Atendimentos\AtendimentoAdminController@salvarObservacoesAtendimento')->name('atendimentos-admin.salvar-observacoes-atendimento');

Route::post('atendimentos-admin/marcar-novo-atendimento', 'Atendimentos\AtendimentoAdminController@marcarNovoAtendimento')->name('atendimentos-admin.marcar-novo-atendimento');

Route::post('atendimentos-admin/cancelar-atendimento', 'Atendimentos\AtendimentoAdminController@cancelarAtendimento')->name('atendimentos-admin.cancelar-atendimento');
