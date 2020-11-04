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
git clone https://github.com/luizrjunior/app-laravel.git
```
2. Criar o schema <i>"applaravel_db_desenv"</i> no banco de dados (MySQL);
3. Criar o arquivo .env baseado no arquivo .env.example e configurar a conexão com banco de dados:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=applaravel_db_desenv
DB_USERNAME=root
DB_PASSWORD=
```
4. Comentar o trecho abaixo no arquivo \app\Provides\AuthServiceProvider.php
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

10. Criar alias ou vhost da aplicação apontando para o diretório:
```
/public
```
Exemplo vhost:
```
<VirtualHost 127.0.0.2:80>
    DocumentRoot "C:/xampp/htdocs/projects/app-laravel/public"
    DirectoryIndex index.php      
    <Directory "C:/xampp/htdocs/projects/app-laravel/public">
        Options All
        AllowOverride All
        Order Allow,Deny
        Allow from all
    </Directory>
</VirtualHost>
```
11. Acessar a aplicação:
```
http://alias-aplicacao/
```
12. Login e Senha:
```
Login: admin@applaravel.com
Senha: abc123
```
