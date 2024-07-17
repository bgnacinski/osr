<?php

namespace App\Database\Seeds;

use App\Models\BillModel;
use App\Models\JobModel;
use CodeIgniter\Database\Seeder;

class BillSeeder extends Seeder
{
    public function run()
    {
        $job_model = new JobModel();
        $job = $job_model->first();

        $data = [
            "client" => "8961017023",
            "job_id" => $job->identificator,
            "currency" => "PLN",
            "created_by" => "anowak"
        ];

        $model = new BillModel();
        try {
            for($i = 0; $i <= 52; $i++){
                $model->insert($data);
            }

            var_dump($model->errors());
        }
        catch(\ReflectionException $ex){
            echo $ex;
        }
    }
}
