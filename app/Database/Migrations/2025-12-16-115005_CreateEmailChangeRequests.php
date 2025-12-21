<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmailChangeRequests extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'new_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'token_hash' => [
                'type' => 'CHAR',
                'constraint' => 64,
            ],
            'expires_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'used_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'user_agent' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey('new_email');
        $this->forge->addKey('token_hash');

        // Prevent multiple active rows per user (we upsert by user_id)
        $this->forge->addUniqueKey('user_id');

        // enforce uniqueness on new_email if you want
        // BUT that can block two users from requesting same email (which is fine).
        // $this->forge->addUniqueKey('new_email');

        $this->forge->createTable('email_change_requests', true);
    }

    public function down()
    {
        $this->forge->dropTable('email_change_requests', true);
    }
}
