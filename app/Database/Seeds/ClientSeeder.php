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
            "email" => "test@example.com",
            "address" => "Kiełczowska 77/79|51-315 Wrocław, Polska"
        ];

        $model = new ClientModel();
        try {
            $model->insert($data);
            var_dump($model->errors());
        }
        catch(\ReflectionException $ex){
            echo $ex;
        }
    }
}
