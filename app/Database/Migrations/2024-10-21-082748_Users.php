<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
  public function up()
  {
    //table aslab
    $this->forge->addField([
      'nim_aslab'     => [
        'type'        => 'CHAR',
        'constraint'  => 20
      ],
      'nama_aslab'    => [
        'type'        => 'VARCHAR',
        'constraint'  => 255
      ],
      'foto_aslab'    => [
        'type'        => 'VARCHAR',
        'constraint'  => 255,
        'null'        => true
      ],
      'kontak_aslab'  => [
        'type'        => 'CHAR',
        'constraint'  => 20,
        'null'        => true
      ],
      'rfid'          => [
        'type'        => 'CHAR',
        'constraint'  => 20,
        'null'        => true
      ]
    ]);
    $this->forge->addKey('nim_aslab', true);
    $this->forge->createTable('aslab');

    //table aslab_kehadiran
    $this->forge->addField([
      'id_kehadiran'      => [
        'type'            => 'INT',
        'constraint'      => 10,
        'auto_increment'  => true
      ],
      'datang'            => [
        'type'            => 'DATETIME',
        'null'            => true
      ],
      'pulang'            => [
        'type'            => 'DATETIME',
        'null'            => true
      ],
      'nim_aslab'         => [
        'type'            => 'CHAR',
        'constraint'      => 20
      ]
    ]);
    $this->forge->addKey('id_kehadiran', true);
    $this->forge->addForeignKey('nim_aslab', 'aslab', 'nim_aslab', 'CASCADE', 'CASCADE');
    $this->forge->createTable('aslab_kehadiran');

    //table users
    $this->forge->addField([
      'username'  => [
        'type'        => 'VARCHAR',
        'constraint'  => 255,
      ],
      'password'  => [
        'type'        => 'VARCHAR',
        'constraint'  => 255,
      ],
      'status_akun' => [
        'type'        => 'INT',
        'constraint'  => 1,
        'comment'     => '0 disable, 1 enable',
      ],
      'id_role'     => [
        'type'        => 'INT',
        'constraint'  => 1
      ],
      'nim_aslab'   => [
        'type'        => 'CHAR',
        'constraint'  => 20
      ]
    ]);
    $this->forge->addKey('username', true);
    $this->forge->addForeignKey('nim_aslab', 'aslab', 'nim_aslab', 'CASCADE', 'CASCADE');
    $this->forge->createTable('users');
  }

  public function down()
  {
    $this->forge->dropTable('aslab');
    $this->forge->dropTable('aslab_kehadiran');
    $this->forge->dropTable('users');
  }
}
