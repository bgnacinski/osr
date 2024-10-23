<?php

namespace App\Database\Seeds;

use App\Models\ProductModel;
use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            "name" => "Wymiana filtra oleju",
            "description" => "Wymiana filtra bez wymiany oleju",
            "amount" => 99.99,
            "tax_rate" => 8
        ];

        $model = new ProductModel();
        $model->save($data);
        var_dump($model->errors());
    }
}
