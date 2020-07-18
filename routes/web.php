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
Route::delete('role-has-permission/destroy', 'Acl\RoleHasPermissionController@destroy')->name('roles.destroy-role-has-permission');

Route::post('role-has-permission/load-permissions-role-json', 'Acl\RoleHasPermissionController@loadPermissionsRoleJson')->name('roles.load-permissions-role-json');

/**
 * CADASTROS
 */
Route::resource('funcaos', 'Cadastros\FuncaoController');
Route::post('funcaos/ativar-desativar-funcao', 'Cadastros\FuncaoController@ativarDesativarFuncao');

Route::resource('locals', 'Cadastros\LocalController');
Route::post('locals/ativar-desativar-local', 'Cadastros\LocalController@ativarDesativarLocal');

Route::resource('atividades', 'Cadastros\AtividadeController');
Route::post('atividades/ativar-desativar-atividade', 'Cadastros\AtividadeController@ativarDesativarAtividade');

/**
 * PESSOAS
 */
Route::resource('pessoas', 'Pessoas\PessoaController');

Route::resource('colaboradors', 'Pessoas\ColaboradorController');
Route::post('colaboradors/ativar-desativar-colaborador', 'Pessoas\ColaboradorController@ativarDesativarColaborador');
