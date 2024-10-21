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
                "unsigned" => true,
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
            "job_id" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => false
            ],
            "tax_rate" => [
                "type" => "set",
                "constraint" => ["23", "8", "7", "5", "4", "0", "none"],
                "null" => false
            ],
            "discount" => [
                "type" => "int",
                "constraint" => 11,
                "null" => false,
                "default" => 0
            ],
            "discount_type" => [
                "type" => "set",
                "constraint" => ["money", "percentage"],
                "null" => false,
                "default" => "money"
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
        $this->forge->addForeignKey("job_id", "jobs", "identificator", "CASCADE", "NO ACTION");

        $this->forge->createTable("bills");

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable("bills");
    }
}
