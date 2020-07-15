<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $this->command->info('Inserindo Usuario: admin');
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'luizrjunior@gmail.com',
            'password' => Hash::make('947bc251'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
    }

}
