<?php

namespace App\Http\Controllers;

use App\Kunci;
use App\Pilihan;
use App\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KunciController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Get kunci on soal
   * 
   * @param String $soal_id
   * @return Response
   */
  public function get($soal_id)
  {
    $pilihan = Soal::find($soal_id)->with('kuncis')->get();
    return response()->json(['data' => $pilihan], 200);
  }

  /**
   * Insert new Kunci
   * 
   * @param Request $request
   * @param String $soal_id
   * @return Response
   */
  public function add(Request $request, $soal_id)
  {
    $this->is_guru();

    $this->validate($request, [
      'kunci_id' => 'required|exists:pilihans,id'
    ]);

    $kunci = new Kunci();
    $kunci->kunci_id = $request->kunci_id;

    $soal = Soal::find($soal_id);

    if (!$soal->kuncis()->save($kunci)) {
      return response()->json(['message' => 'Error can not add new Kunci Jawaban for now'], 404);
    }

    return response()->json(['message' => 'Kunci Jawaban created', 'data' => $kunci], 200);
  }

  /**
   * Delete Kunci Jawaban
   * 
   * @param String $id
   * @return Response
   */
  public function delete($id)
  {
    $this->is_guru();

    $kunci = Kunci::find($id);

    if (!$kunci->delete()) {
      return response()->json(['message' => 'Failed to delete Kunci Jawaban ' . $id], 400);
    }
    return response()->json(['message' => 'Delete success'], 200);
  }
}
