<?php

namespace App\Controllers;

use App\Models\M_Aslab;
use App\Models\M_Aslab_Kehadiran;
use CodeIgniter\RESTful\ResourceController;

class Aslab extends ResourceController
{

  protected $aslab;
  protected $aslab_kehadiran;

  public function __construct()
  {
    $this->aslab = new M_Aslab();
    $this->aslab_kehadiran = new M_Aslab_Kehadiran();
  }

  public function index()
  {
    $data = $this->aslab->getAllData();
    return $this->respond($data);
  }

  public function show($rfid = null)
  {
    $data = $this->aslab->getDataByRFID($rfid);
    if ($data) {
      return $this->respond($data);
    } else {
      return $this->failNotFound('Data tidak ditemukan');
    }
  }

  public function create()
  {
    $rfid     = $this->request->getPost('UIDs');
    $cek_data = $this->aslab->getDataByRFID($rfid);

    if (!$cek_data) {
      return $this->failNotFound('Data tidak ditemukan');
    }

    if (!$this->validate([
      'UIDs'  => 'required'
    ])) {
      return $this->failValidationErrors($this->validator->getErrors());
    }

    $cek_datang = $this->aslab_kehadiran->getDataKehadiranByRFID($rfid);
    if (!$cek_datang) {
      $input = [
        'tanggal_masuk' => date('Y-m-d H:i:s'),
        'nim_aslab'     => $cek_data['nim_aslab']
      ];
      $this->aslab_kehadiran->insert($input);
      // return $this->respondCreated($input, 'Kehadiran berhasil ditambahkan.');
      return $this->respond('Jam datang berhasil disimpan.');
    } else {
      if ($cek_datang['tanggal_pulang'] == null) {
        $tanggal_masuk  = $cek_datang['tanggal_masuk'];
        $id_kehadiran   = $cek_datang['id_kehadiran'];
        $split_tanggal  = explode(' ', $tanggal_masuk);
        $split_waktu    = explode(':', $split_tanggal[1]);
        $jam            = $split_waktu[0] * 60 * 60;
        $menit          = $split_waktu[1] * 60;
        $detik          = $split_waktu[2];
        $total_masuk    = $jam + $menit + $detik;
        $total_sekarang = (date('H') * 60 * 60) + (date('i') * 60) + date('s');
        $minimal        = 5 * 60;
        if (($total_sekarang - $total_masuk) >= $minimal) {
          $this->aslab_kehadiran->updateDataKehadiranByRFID(date('Y-m-d H:i:s'), $id_kehadiran);
          return $this->respond('Jam pulang berhasil disimpan.');
        } else {
          return $this->respond('Jam pulang gagal ditambahkan.');
        }
      } else {
        $input = [
          'tanggal_masuk' => date('Y-m-d H:i:s'),
          'nim_aslab'     => $cek_data['nim_aslab']
        ];
        $this->aslab_kehadiran->insert($input);
        return $this->respond('Jam datang berhasil disimpan.');
      }
    }
  }
}
