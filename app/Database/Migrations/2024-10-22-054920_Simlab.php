<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Simlab extends Migration
{
  public function up()
  {
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
        'constraint'      => 11,
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

    //table laboran
    $this->forge->addField([
      'nip_laboran'     => [
        'type'          => 'CHAR',
        'constraint'    => 15
      ],
      'nama_laboran'    => [
        'type'          => 'VARCHAR',
        'constraint'    => 255
      ],
      'posisi_laboran'  => [
        'type'          => 'VARCHAR',
        'constraint'    => 255,
        'null'          => true
      ],
      'status_aktif'    => [
        'type'          => 'INT',
        'constraint'    => 11,
        'null'          => true,
        'comment'       => '0 non-aktif, 1 aktif'
      ]
    ]);
    $this->forge->addKey('nip_laboran', true);
    $this->forge->createTable('laboran');

    //table laboratorium_kategori
    $this->forge->addField([
      'id_lab_kategori'   => [
        'type'            => 'INT',
        'constraint'      => 11,
        'auto_increment'  => true
      ]
    ]);

    //table laboratorium
    $this->forge->addField([
      'id_lab'            => [
        'type'            => 'INT',
        'constraint'      => 11,
        'auto_increment'  => true
      ],
      'nama_lab'          => [
        'type'            => 'VARCHAR',
        'constraint'      => 255,
      ],
      'id_lab_kategori'   => [
        'type'            => 'INT',
        'constraint'      => 11
      ],
      'id_lab_lokasi'     => [
        'type'            => 'INT',
        'constraint'      => 11
      ],
      'id_prodi'          => [
        'type'            => 'INT',
        'constraint'      => 11
      ]
    ]);
    $this->forge->addKey('id_lab', true);
    $this->forge->createTable('laboratorium');

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
