<?php

use Illuminate\Database\Seeder;

class UsersHasRolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $this->command->info('Inserindo e Associando Perfil: Administrador ao Usuario: admin');
        DB::table('users_has_roles')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);
        
    }

}
