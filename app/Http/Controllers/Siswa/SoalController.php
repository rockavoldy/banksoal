<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Jawaban;
use App\Kunci;
use App\Matpel;
use App\Skor;
use App\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoalController extends Controller
{
  /**
   * get Soal random/user access
   * 
   * @param String matpel_id
   * @return Response
   */
  public function getSoal($matpel_id)
  {
    $soal = Soal::where('matpel_id', $matpel_id)->inRandomOrder()->with(['pilihans' => function ($pilihan) {
      $pilihan->inRandomOrder();
    }])->get();

    return response()->json(['data' => $soal]);
  }

  /**
   * save Jawaban siswa
   * 
   * @param String soal_id
   */
  public function saveJawaban(Request $request, $soal_id)
  {
    $jawaban = new Jawaban();

    $jawaban->siswa_id = Auth::user()->id;
    $jawaban->soal_id = $soal_id;
    $jawaban->pilihan_id = $request->pilihan_id;

    if (!$jawaban->save()) {
      return false; // to notify frontend and try to push again
    }
    $kunci = Kunci::where('soal_id', $soal_id)->first()->id;
    $jawaban_user = $request->pilihan_id;
    if ($kunci === $jawaban_user) {
      $nilai = Soal::find($soal_id)->skor;
      $this->updateSkor(true, $nilai, $request->waktu);
      return response()->json(['message' => 'success']);
      exit();
    }
    $this->updateSkor(false, 0, $request->waktu);
    return response()->json(['message' => 'Success']);
  }

  /**
   * update Skor
   * 
   * @param boolean $benar
   * @param integer $nilai
   * @param integer $waktu
   * @return true
   */
  private function updateSkor($benar, $nilai, $waktu)
  {
    $skor = Skor::where('siswa_id', Auth::user()->id)->first();

    // return response()->json($skor);
    if (!$skor) {
      $skor = new Skor();
    }

    $skor->siswa_id = Auth::user()->id;
    if ($benar) {
      $skor->benar = $skor->benar + 1;
      $skor->skor = $skor->skor + $nilai;
    }
    $skor->waktu = $waktu;
    $skor->save();

    if (!$skor->save()) {
      return false;
    }
    return true;
  }
}
