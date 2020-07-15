<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $this->command->info('1 - Inserindo Permissao: Menu_Acl');
        DB::table('permissions')->insert([
            'name' => 'Menu_Acl',
            'description' => 'Permissão para o menu Controle de Acesso.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

    }

}
