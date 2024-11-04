<?php

namespace App\Controllers;

use App\Models\M_Aslab;
use App\Models\M_Aslab_Kehadiran;

class Test extends BaseController
{

  protected $aslab;
  protected $aslab_kehadiran;

  public function __construct()
  {
    $this->aslab            = new M_Aslab();
    $this->aslab_kehadiran  = new M_Aslab_Kehadiran();
  }

  public function index()
  {
    $rfid = 'asd123';
    $waktu_sekarang = date('Y-m-d H:i:s');
    echo "Coba Tes Pakai tag RFID {$rfid}<br>";
    echo "Waktu sekarang {$waktu_sekarang}<br>";
    $pemilik_id     = $this->aslab->getDataByRFID($rfid);
    echo "Pemilik identitas adalah {$pemilik_id['nama_aslab']} dengan NIM {$pemilik_id['nim_aslab']}<br>";
    $cek_kehadiran  = $this->aslab_kehadiran->getDataKehadiranByRFID($rfid);
    if (!$cek_kehadiran) {
      echo "Belum melakukan presensi kehadiran hari ini<br>";
      $input = [
        'tanggal_masuk' => $waktu_sekarang,
        'nim_aslab'     => $pemilik_id['nim_aslab']
      ];
      $this->aslab_kehadiran->insert($input);
      echo "Jam kehadiran sukses disimpan di waktu {$waktu_sekarang}<br>";
    } else {
      if ($cek_kehadiran['tanggal_pulang'] == null) {
        echo "Sudah melakukan presensi kehadiran hari ini<br>";
        $tanggal_masuk  = $cek_kehadiran['tanggal_masuk'];
        $id_kehadiran   = $cek_kehadiran['id_kehadiran'];
        $split_tanggal  = explode(' ', $tanggal_masuk);
        $split_waktu    = explode(':', $split_tanggal[1]);
        $jam            = $split_waktu[0] * 60 * 60;
        $menit          = $split_waktu[1] * 60;
        $detik          = $split_waktu[2];
        $total_masuk    = $jam + $menit + $detik;
        $total_sekarang = (date('H') * 60 * 60) + (date('i') * 60) + date('s');
        $minimal        = 5 * 60;
        if (($total_sekarang - $total_masuk) >= $minimal) {
          echo "Sudah bisa absen pulang<br>";
          $this->aslab_kehadiran->updateDataKehadiranByRFID(date('Y-m-d H:i:s'), $id_kehadiran);
          echo "Jam pulang sukses disimpan di waktu {$waktu_sekarang}";
        } else {
          echo "Belum bisa absen pulang";
        }
      } else {
        $input = [
          'tanggal_masuk' => $waktu_sekarang,
          'nim_aslab'     => $pemilik_id['nim_aslab']
        ];
        $this->aslab_kehadiran->insert($input);
        echo "Jam kehadiran sukses disimpan di waktu {$waktu_sekarang}<br>";
      }
    }
  }
}
