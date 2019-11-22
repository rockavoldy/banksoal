<?php

namespace App\Http\Controllers;

use App\Kunci;
use App\Pilihan;
use App\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PilihanController extends Controller
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
   * Get all pilihan on soal
   * 
   * @param String $soal_id
   * @return Response
   */
  public function get($soal_id)
  {
    $pilihan = Soal::where('id', $soal_id)->with(['pilihans' => function ($pil) {
      $pil->with('kuncis');
    }])->with('kuncis')->get();
    return response()->json(['data' => $pilihan], 200);
  }

  /**
   * Insert new Pilihan
   * 
   * @param Request $request
   * @param String $soal_id
   * @return Response
   */
  public function add(Request $request, $soal_id)
  {
    $this->is_guru();

    // $this->validate($request, [
    //   'pilihan' => 'required'
    // ]);
    foreach ($request->pilihan as $pil) {
      $pilihan = new Pilihan();
      $pilihan->pilihan = $pil['pilihan'];
      $soal = Soal::find($soal_id);
      $soal->pilihans()->save($pilihan);
    }
    // $pilihan = new Pilihan();
    // $pilihan->pilihan = $request->pilihan;

    // $soal = Soal::find($soal_id);

    // if (!$soal->pilihans()->save($pilihan)) {
    //   return response()->json(['message' => 'Error can not add new Pilihan Jawaban for now'], 404);
    // }

    return response()->json(['message' => 'Pilihan Jawaban created', 'data' => $pilihan], 200);
  }

  /**
   * Delete Pilihan Jawaban
   * 
   * @param String $id
   * @return Response
   */
  public function delete($id)
  {
    $this->is_guru();

    $pilihan = Pilihan::find($id);

    if (!$pilihan->delete()) {
      return response()->json(['message' => 'Failed to delete Pilihan Jawaban ' . $id], 400);
    }
    return response()->json(['message' => 'Delete success'], 200);
  }
}
