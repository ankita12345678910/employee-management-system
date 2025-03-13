<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoginDetailsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('user_name');
        $this->forge->createTable('login_details');
    }

    public function down()
    {
        $this->forge->dropTable('login_details');
    }
}
