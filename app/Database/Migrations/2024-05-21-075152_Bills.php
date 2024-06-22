<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bills extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();

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
            "client" => [
                "type" => "varchar",
                "constraint" => 15,
                "null" => false
            ],
            "tax_rate" => [
                "type" => "float",
                "constraint" => 5,
                "null" => true
            ],
            "status" => [
                "type" => "set",
                "constraint" => ["ok", "pending", "payment", "returned"],
                "null" => false
            ],
            "currency" => [
                "type" => "varchar",
                "constraint" => 3,
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
        $this->forge->addForeignKey("created_by", "users", "login", "CASCADE", "NO ACTION");
        $this->forge->addForeignKey("client", "clients", "nip", "CASCADE", "NO ACTION");

        $this->forge->createTable("bills");

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable("bills");
    }
}
