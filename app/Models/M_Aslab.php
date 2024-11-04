<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Aslab extends Model
{

  protected $table = 'aslab';
  protected $primaryKey = 'nim_aslab';
  protected $allowedFields = ['nim_aslab', 'nama_aslab', 'rfid'];

  public function getAllData()
  {
    return $this->findAll();
  }

  public function getDataByRFID($rfid)
  {
    $this->where('rfid', $rfid);
    return $this->first();
  }
}
