<?php

namespace App\Database\Seeds;

use App\Models\ClientModel;
use CodeIgniter\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $data = [
            "name" => "Januszex",
            "nip" => "8961017023",
            "email" => "test@example.com"
        ];

        $model = new ClientModel();
        try {
            $model->insert($data);
        }
        catch(\ReflectionException $ex){
            echo $ex;
        }
    }
}
