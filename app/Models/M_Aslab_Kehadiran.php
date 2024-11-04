<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Aslab_Kehadiran extends Model
{

  protected $table = 'aslab_kehadiran';
  protected $primaryKey = 'id_kehadiran';
  protected $allowedFields = ['tanggal_masuk', 'tanggal_pulang', 'nim_aslab'];

  public function getDataKehadiranByRFID($rfid)
  {
    $this->join('aslab', 'aslab_kehadiran.nim_aslab = aslab.nim_aslab');
    $this->where('rfid', $rfid);
    $this->where('DATE(tanggal_masuk) = "' . date('Y-m-d') . '"');
    $this->orderBy('tanggal_masuk', 'DESC');
    return $this->first();
  }

  public function updateDataKehadiranByRFID($tanggal_pulang, $id_kehadiran)
  {
    $this->set('tanggal_pulang', $tanggal_pulang);
    $this->where('id_kehadiran', $id_kehadiran);
    $this->update();
  }
}
