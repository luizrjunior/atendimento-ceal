## Instalação do Atendimento CEAL
Procedimentos para instalação da Aplicação:

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
6. Gerar a chave identificadora da Aplicação
```
php artisan key:generate
```
7. Gerar as Tabelas do Banco de Dados
``` 
php artisan migrate
```
8. Popular as primeiras tabelas do sistema
```
composer dump-autoload
```
```
php artisan db:seed
```
9. Criar o storage link para mapear o armazenamento dos arquivos:
```
php artisan storage:link
```
10. Descomentar o trecho de código descrito no item 4
11. Login e Senha:
```
Login: luizrjunior@gmail.com
Senha: 947bc251
```
