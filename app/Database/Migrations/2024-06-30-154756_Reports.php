<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Reports extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "auto_increment" => true,
                "constraint" => 11,
                "unsigned" => true,
                "null" => false
            ],
            "job_id" => [
                "type" => "int",
                "constraint" => 11,
                "unsigned" => true,
                "null" => false
            ],
            "content" => [
                "type" => "text",
                "null" => false
            ],
            "files" => [
                "type" => "varchar",
                "constraint" => 250,
                "null" => true
            ],
            "created_by" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => false
            ],
            "number" => [
                "type" => "int",
                "constraint" => 11,
                "unsigned" => true,
                "null" => false
            ],
            "created_at" => [
                "type" => "datetime",
                "null" => false
            ],
            "updated_at" => [
                "type" => "datetime",
                "null" => true
            ],
            "deleted_at" => [
                "type" => "datetime",
                "null" => true
            ]
        ]);

        $this->forge->addPrimaryKey("id");
        $this->forge->addForeignKey("job_id", "jobs", "id", "CASCADE", "CASCADE");

        $this->forge->createTable("reports");
    }

    public function down()
    {
        $this->forge->dropTable("reports");
    }
}
