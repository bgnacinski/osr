<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bills extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "int",
                "constraint" => 11,
                "auto_increment" => true,
                "null" => false
            ],
            "identificator" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => false
            ],
            "status" => [
                "type" => "set",
                "constraint" => ["ok", "pending", "payment", "returned"],
                "null" => false
            ],
            "created_by" => [
                "type" => "varchar",
                "constraint" => 20
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

        $this->forge->createTable("bills");
    }

    public function down()
    {
        $this->forge->dropTable("bills");
    }
}
