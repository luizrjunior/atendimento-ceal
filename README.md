<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

# AppLaravel - Application Laravel

O AppLaravel é uma aplicação PHP orientado a objeto utilizando Framework Laravel. Este sistema é tipo um ERP onde existem vários módulos como por exemplo: <b>Recursos Humanos</b>, <b>Financeiro</b>, <b>Reservas de Quartos de Hotel</b>, <b>Reservas de Brinquedos</b>, <b>Frente de Caixa</b>, <b>Controle de Estoque</b> e etc.

## Instalação do AppLaravel
Procedimentos para instalação do sistema:

1. Clonar o repositório do projeto no GitHub:
```
git clone https://github.com/luizrjunior/atendimento-ceal.git
```
2. Comentar o trecho abaixo no arquivo \app\Provides\AuthServiceProvider.php
```
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $permissions = Permission::with('roles')->get();
        foreach ($permissions as $permission) {
            $gate->define($permission->name, function (User $user) use($permission) {
                return $user->hasPermission($permission);
            });
        }
        
        $permissionsUserS = Permission::with('users')->get();
        foreach ($permissionsUserS as $permissionUser) {
            $gate->define($permissionUser->name, function (User $user) use($permissionUser) {
                return $user->hasPermission($permissionUser);
            });
        }
        
        $gate->before(function (User $user) {
            if ($user->hasAnyRoles('Administrator')) {
                return true;
            }
        });
    }
```
3. Criar o schema <i>"ceal"</i> no banco de dados (MySQL);
4. Criar o arquivo .env baseado no arquivo .env.example e configurar a conexão com banco de dados:
```
DB_CONNECTION=mysql
DB_HOST=easy.brasiliarfid.com.br
DB_PORT=3306
DB_DATABASE=ceal
DB_USERNAME=ceal
DB_PASSWORD=qwerty321
```
5. Instalar as dependencias
```
composer install
```
6. Gerar as Tabelas do Banco de Dados
``` 
php artisan migrate
```
7. Popular as primeiras tabelas do sistema
```
composer dump-autoload
```
```
php artisan db:seed
```
8. Criar o storage link para mapear o armazenamento dos arquivos:
```
php artisan storage:link
```
9. Descomentar o trecho de código descrito no item 4
10. Login e Senha:
```
Login: luizrjunior@gmail.com
Senha: 947bc251
```
