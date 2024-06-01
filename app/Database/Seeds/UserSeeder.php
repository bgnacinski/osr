<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                "name" => "Admin",
                "login" => "admin",
                "password" => "admin",
                "role" => "superuser"
            ],
            [
                "name" => "Henryk Budowa",
                "login" => "hbudowa",
                "password" => "hbudowa",
                "role" => "manager"
            ],
            [
                "name" => "Agata Nowak",
                "login" => "anowak",
                "password" => "anowak",
                "role" => "regular"
            ],
            [
                "name" => "Jurek Pędziwiatr",
                "login" => "jpedziwiatr",
                "password" => "jpedziwiatr",
                "role" => "viewer"
            ]
        ];

        $model = new UserModel();
        $model->skipValidation();

        foreach($data as $data_cell){
            $model->save($data_cell);
        }
    }
}
