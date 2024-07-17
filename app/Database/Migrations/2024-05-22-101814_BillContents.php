<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BillContents extends Migration
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
            "bill_id" => [
                "type" => "int",
                "constraint" => 11,
                "unsigned" => true,
                "null" => false
            ],
            "product_name" => [
                "type" => "varchar",
                "constraint" => 100,
                "null" => false
            ],
            "quantity" => [
                "type" => "int",
                "constraint" => 11,
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
        $this->forge->addForeignKey("bill_id", "bills", "id");
        $this->forge->addForeignKey("product_name", "products", "name");

        $this->forge->createTable("bill_contents");
    }

    public function down()
    {
        $this->forge->dropTable("bill_contents");
    }
}
