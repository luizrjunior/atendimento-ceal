<?php

use Illuminate\Database\Seeder;

class RolesHasPermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        $this->command->info('Inserindo Permissao: App_Usuarios -> Perfil: Administrador_Hotel');
        DB::table('roles_has_permissions')->insert([
            'permission_id' => 2,
            'role_id' => 3
        ]);

    }

}

