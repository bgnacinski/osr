<?php

namespace App\Database\Seeds;

use App\Models\JobModel;
use CodeIgniter\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run()
    {
        $data = [
            "client" => "8961017023",
            "status" => "ok",
            "description" => "Test job description. 1 PC to build",
            "comment" => "AMD-based",
            "created_by" => "anowak"
        ];

        $model = new JobModel();
        $model->insert($data);

        var_dump($model->errors());
    }
}
