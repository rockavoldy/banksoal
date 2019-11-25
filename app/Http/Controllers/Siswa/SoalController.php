<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Jawaban;
use App\Kunci;
use App\Matpel;
use App\Skor;
use App\Soal;
use App\User;
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
   * @param String Request->pilihan_id
   * @param String soal_id
   */
  public function saveJawaban(Request $request, $soal_id)
  {

    $soal = Soal::find($soal_id);
    $jawaban = new Jawaban();

    $jawaban->soal_id = $soal_id;
    $jawaban->pilihan_id = $request->pilihan_id;
    $jawaban->alasan = $request->alasan;

    $kunci = Kunci::where('soal_id', $soal_id)->first()->kunci_id;
    $jawaban_user = $request->pilihan_id;

    if ($kunci == $jawaban_user) {
      $jawaban->is_benar = true;
    } else {
      $jawaban->is_benar = false;
    }

    $user = User::find(Auth::user()->id);
    if ($user->jawabans()->save($jawaban)) {
      if (!$skor = Skor::where('siswa_id', Auth::user()->id)->first()) {
        $skor = new Skor();
        $skor->benar = 0;
        $skor->skor = 0;
        $skor->waktu = 0;
      }

      if ($jawaban->is_benar) {
        $skor->benar += 1;
        $skor->skor += $soal->skor;
      }
      $user->skors()->save($skor);
      return response()->json(['message' => 'success'], 200);
    }
    return response()->json(['message' => 'failed'], 404);
  }
}
