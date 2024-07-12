<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jobs extends Migration
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
            "status" => [
                "type" => "set",
                "constraint" => ["ok", "pending", "payment"],
                "null" => false
            ],
            "description" => [
                "type" => "text",
                "null" => false
            ],
            "comment" => [
                "type" => "text",
                "null" => true
            ],
            "created_at" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => false
            ],
            "updated_at" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => false
            ],
            "deleted_at" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => true
            ]
        ]);

        $this->forge->addPrimaryKey("id");
        $this->forge->addForeignKey("client", "clients", "nip", "CASCADE", "CASCADE");

        $this->forge->createTable("jobs");
    }

    public function down()
    {
        $this->forge->dropTable("jobs");
    }
}
