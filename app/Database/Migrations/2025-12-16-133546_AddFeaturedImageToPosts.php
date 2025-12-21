<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFeaturedImageToPosts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('posts', [
            'featured_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'meta_description', // adjust if needed
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('posts', 'featured_image');
    }
}
