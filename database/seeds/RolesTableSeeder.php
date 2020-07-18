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
            'description' => 'Perfil administrador geral do sistema.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('2 - Inserindo Perfil: Diretor DIATE');
        DB::table('roles')->insert([
            'name' => 'Diretor DIATE',
            'description' => 'Perfil diretor DIATE.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('3 - Inserindo Perfil: Dirigente AF');
        DB::table('roles')->insert([
            'name' => 'Dirigente AF',
            'description' => 'Perfil dirigente AF.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('4 - Inserindo Perfil: Acolhedor AF');
        DB::table('roles')->insert([
            'name' => 'Acolhedor AF',
            'description' => 'Perfil dirigente AF.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->command->info('5 - Inserindo Perfil: Dialogador AF');
        DB::table('roles')->insert([
            'name' => 'Dialogador AF',
            'description' => 'Perfil dirigente AF.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

    }

}
