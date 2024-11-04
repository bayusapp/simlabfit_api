<?php

if (!function_exists('hitungSelisih')) {
  function hitungSelisih($date)
  {
    $split      = explode(' ', $date);
    $masuk      = explode(':', $split[1]);
    $jam        = $masuk[0] * 60 * 60;
    $menit      = $masuk[1] * 60;
    $detik      = $masuk[2];
    $jam_masuk  = $jam + $menit + $detik;
    $jam_pulang = (date('H') * 60 * 60) + (date('i') * 60) + date('s');
    // if ((((date('H') * 60 * 60) + (date('i') * 60) + date('s')) - $jam_masuk) >= (5 * 60)) {
    if (($jam_pulang - $jam_masuk) >= (5 * 60)) {
      return true;
    } else {
      return false;
    }
  }
}
