<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPostsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true,
            ],
            "user_id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,


            ],
            "slug" => [
                "type" => "VARCHAR",
                "constraint" => 255,
                "null" => false,
                "unique" => true,
            ],
            "title" => [
                "type" => "VARCHAR",
                "constraint" => 255,
                "null" => false,
            ],
            "meta_description" => [
                "type" => "VARCHAR",
                "constraint" => 255,
                "null" => false,
            ],
            "content" => [
                "type" => "TEXT",
                "null" => false,
            ],
            "created_at" => [
                "type" => "DATETIME",
                "null" => false,
            ],
            "updated_at" => [
                "type" => "DATETIME",
                "null" => false,
            ],
        ]);

        $this->forge->addKey("id", true);
        $this->forge->addForeignKey(
            "user_id",
            "users",
            "id",
            "CASCADE",
            "CASCADE"
        );
        $this->forge->createTable("posts");
    }

    public function down()
    {
        $this->forge->dropTable("posts");
    }
}
