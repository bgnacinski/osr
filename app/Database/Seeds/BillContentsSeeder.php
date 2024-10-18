<?php

namespace App\Database\Seeds;

use App\Models\BillEntryModel;
use CodeIgniter\Database\Seeder;

class BillContentsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            "bill_id" => 1,
            "product_name" => "Wymiana filtra oleju",
            "quantity" => 1,
            "price" => 1000.11
        ];

        $model = new BillEntryModel();
        $model->save($data);
        var_dump($model->errors());
    }
}
