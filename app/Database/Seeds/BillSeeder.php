<?php

namespace App\Database\Seeds;

use App\Models\BillModel;
use CodeIgniter\Database\Seeder;

class BillSeeder extends Seeder
{
    public function run()
    {
        $data = [
            "identificator" => "testststs",
            "client" => 8961017023,
            "tax_rate" => 23,
            "status" => "ok",
            "created_by" => "anowak"
        ];

        $model = new BillModel();
        try {
            $model->insert($data);
        }
        catch(\ReflectionException $ex){
            echo $ex;
        }
    }
}
