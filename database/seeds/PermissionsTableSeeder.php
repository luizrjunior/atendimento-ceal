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

        $this->command->info('4 - Inserindo Permissao: Menu_Agendas');
        DB::table('permissions')->insert([
            'name' => 'Menu_Agendas',
            'description' => 'Permissão para o menu Agendas.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('5 - Inserindo Permissao: Item_Funcoes');
        DB::table('permissions')->insert([
            'name' => 'Item_Funcoes',
            'description' => 'Permissão para o item Funções.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('6 - Inserindo Permissao: Item_Locais');
        DB::table('permissions')->insert([
            'name' => 'Item_Locais',
            'description' => 'Permissão para o item Locais.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('7 - Inserindo Permissao: Item_Motivos');
        DB::table('permissions')->insert([
            'name' => 'Item_Motivos',
            'description' => 'Permissão para o item Motivos.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('8 - Inserindo Permissao: Item_Orientacoes');
        DB::table('permissions')->insert([
            'name' => 'Item_Orientacoes',
            'description' => 'Permissão para o item Orientações.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('9 - Inserindo Permissao: Item_Atividades');
        DB::table('permissions')->insert([
            'name' => 'Item_Atividades',
            'description' => 'Permissão para o item Atividades.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('10 - Inserindo Permissao: Item_Participantes');
        DB::table('permissions')->insert([
            'name' => 'Item_Participantes',
            'description' => 'Permissão para o item Participantes.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('11 - Inserindo Permissao: Item_Pessoas');
        DB::table('permissions')->insert([
            'name' => 'Item_Pessoas',
            'description' => 'Permissão para o item Pessoas.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('12 - Inserindo Permissao: Item_Agendamentos');
        DB::table('permissions')->insert([
            'name' => 'Item_Agendamentos',
            'description' => 'Permissão para o item Agendamentos.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('13 - Inserindo Permissao: Item_Atendimentos');
        DB::table('permissions')->insert([
            'name' => 'Item_Atendimentos',
            'description' => 'Permissão para o item Atendimentos.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

    }

}
