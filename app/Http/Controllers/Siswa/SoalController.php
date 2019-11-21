<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Matpel;
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
    // $soal = Soal::where('matpel_id', $matpel_id)->paginate(1);
    $soal = Soal::where('matpel_id', $matpel_id)->inRandomOrder()->get();

    return response()->json(['data' => $soal]);
  }
}
