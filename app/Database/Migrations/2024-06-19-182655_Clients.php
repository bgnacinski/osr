<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Clients extends Migration
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
            "name" => [
                "type" => "varchar",
                "constraint" => 250,
                "null" => false
            ],
            "nip" => [
                "type" => "varchar",
                "constraint" => 15,
                "null" => false
            ],
            "email" => [
                "type" => "varchar",
                "constraint" => 250,
                "null" => false
            ],
            "address" => [
                "type" => "varchar",
                "constraint" => 300,
                "null" => false
            ],
            "created_at" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => false
            ],
            "updated_at" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => true
            ],
            "deleted_at" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => true
            ]
        ]);

        $this->forge->addPrimaryKey("id");
        $this->forge->addKey("nip");

        $this->forge->createTable("clients");

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable("clients");
    }
}
