<?php

namespace App\Database\Seeds;

use App\Models\ReportsModel;
use CodeIgniter\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run()
    {
        $data = [
            "job_id" => 1,
            "content" => "Test report to job of ID 1"
        ];

        $model = new ReportsModel();
        $model->insert($data);

        var_dump($model->errors());
    }
}
