<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddViewsToPostsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('posts', [
            'views' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('posts', 'views');
    }
}
