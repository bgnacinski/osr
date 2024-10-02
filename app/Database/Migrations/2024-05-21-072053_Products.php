<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "int",
                "constraint" => 11,
                "auto_increment" => true,
                "unsigned" => true,
                "null" => false
            ],
            "friendly_id" => [
                "type" => "varchar",
                "constraint" => 100,
                "null" => false
            ],
            "name" => [
                "type" => "varchar",
                "constraint" => 100,
                "null" => false
            ],
            "description" => [
                "type" => "text",
                "constraint" => 250,
                "null" => true
            ],
            "amount" => [
                "type" => "decimal",
                "constraint" => "10,2",
                "null" => false
            ],
            "tax_rate" => [
                "type" => "float",
                "constraint" => 5,
                "null" => true
            ],
            "created_at" => [
                "type" => "datetime",
                "null" => false
            ],
            "updated_at" => [
                "type" => "datetime",
                "null" => true
            ]
        ]);

        $this->forge->addPrimaryKey("id");
        $this->forge->addKey("name", false, true, "name");
        
        $this->forge->createTable("products");
    }

    public function down()
    {
        $this->forge->dropTable("products");
    }
}
