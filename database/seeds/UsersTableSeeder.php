<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombre'=>'carmen',
            'apellido'=>'castro',
            'usuario'=>'carmen98',
            'email'=>'carmen@gmail.com',
            'password'=>bcrypt('1234'),
            'direccion'=>'villacastro',
            'sexo'=>1
            ]);
        User::create([
            'nombre'=>'jesus',
            'apellido'=>'bolivar',
            'usuario'=>'bolijesus98',
            'email'=>'bolijesus98@gmail.com',
            'password'=>bcrypt('1234'),
            'direccion'=>'sicarare',
            'sexo'=>0
            ]);
    }
}
