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

        $this->command->info('2 - Inserindo Permissao: Menu_Cadastros');
        DB::table('permissions')->insert([
            'name' => 'Menu_Cadastros',
            'description' => 'Permissão para o menu Cadastros.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('3 - Inserindo Permissao: Menu_Colaboradores');
        DB::table('permissions')->insert([
            'name' => 'Menu_Colaboradores',
            'description' => 'Permissão para o menu Colaboradores.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('4 - Inserindo Permissao: Item_Participantes');
        DB::table('permissions')->insert([
            'name' => 'Item_Participantes',
            'description' => 'Permissão para o item Participantes.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

    }

}
