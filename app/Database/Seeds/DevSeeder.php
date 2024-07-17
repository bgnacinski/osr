<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DevSeeder extends Seeder
{
    public function run()
    {
        $this->call("UserSeeder");
        $this->call("ProductSeeder");
        $this->call("ClientSeeder");
        $this->call("JobSeeder");
        $this->call("BillSeeder");
        $this->call("BillContentsSeeder");
        $this->call("ReportSeeder");
    }
}
