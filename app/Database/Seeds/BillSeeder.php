<?php

namespace App\Database\Seeds;

use App\Models\BillModel;
use CodeIgniter\Database\Seeder;

class BillSeeder extends Seeder
{
    public function run()
    {
        $data = [
            "client" => 8961017023,
            "tax_rate" => 23,
            "status" => "ok",
            "created_by" => "anowak"
        ];

        $model = new BillModel();
        try {
            $model->insert($data);
            var_dump($model->errors());
        }
        catch(\ReflectionException $ex){
            echo $ex;
        }
    }
}
