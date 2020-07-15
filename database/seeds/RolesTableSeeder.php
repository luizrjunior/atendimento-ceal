<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        $this->command->info('1 - Inserindo Perfil: Administrador');
        DB::table('roles')->insert([
            'name' => 'Administrador',
            'description' => 'Perfil Administrador do Sistema.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

    }

}
