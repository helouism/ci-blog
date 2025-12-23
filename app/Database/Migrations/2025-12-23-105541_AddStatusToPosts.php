<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToPosts extends Migration
{
    public function up()
    {
         $this->forge->addColumn('posts', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'published'],
                'default' => 'draft',
                'null' => false,
            ],
        ]);
    }

    public function down()
    {  $this->forge->dropColumn('posts', 'views');
        $this->forge->dropColumn('posts', 'status');
    }
}
