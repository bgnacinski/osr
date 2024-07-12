<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            "name" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => false
            ],
            "login" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => false
            ],
            "password" => [
                "type" => "varchar",
                "constraint" => 255,
                "null" => false
            ],
            "role" => [
                "type" => "set",
                "constraint" => ["admin", "manager", "regular", "viewer"],
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
        $this->forge->addKey("login");

        $this->forge->createTable("users");
    }

    public function down()
    {
        $this->forge->dropTable("users");
    }
}
