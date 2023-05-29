<?php

namespace App\Database\Seeds;

use App\Models\User;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserSeed extends Seeder
{
    public function run()
    {
        $user = new UserModel();
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            $user->save(
                [
                    'nama'        =>    $faker->name,
                    'email'       =>    $faker->email,
                    'password'    =>    password_hash($faker->password, PASSWORD_DEFAULT),
                    'no_hp'       =>    $faker->e164PhoneNumber,
                    'alamat'     =>    $faker->address
                ]
            );
        }
    }
}
