<?php

namespace App\Http\Controllers;

use App\Matpel;
use App\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoalController extends Controller
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
   * Get all soal
   * 
   * @return Response
   */
  public function getAll()
  {
    $soals = Soal::get();
    return response()->json(['data' => $soals], 200);
  }

  /**
   * Get all soal on matpel
   * 
   * @param String $kode_matpel
   * @return Response
   */
  public function getAllWithMatpel($kode_matpel)
  {
    $soals = Matpel::where('kode_matpel', $kode_matpel)->with('soals')->get();
    return response()->json(['data' => $soals], 200);
  }

  /**
   * Get one soal using kode
   * 
   * @param String $id
   * @return Response
   */
  public function getOne($id)
  {
    $soal = Soal::find($id);

    if (!$soal) {
      return response()->json(['message' => 'No data'], 404);
    }
    return response()->json(['data' => $soal], 200);
  }

  /**
   * Insert new Soal
   * 
   * @param Request $request
   * @return Response
   */
  public function add(Request $request)
  {
    $this->is_guru();

    $this->validate($request, [
      'pertanyaan' => 'required',
      'skor' => 'required',
      'kode_matpel' => 'required|exists:matpels'
    ]);

    $soal = new Soal();
    $soal->guru_id = Auth::user()->id;
    $soal->pertanyaan = $request->pertanyaan;
    $soal->skor = $request->skor;

    $matpel = Matpel::where('kode_matpel', $request->kode_matpel)->first();
    if (!$matpel->soals()->save($soal)) {
      return response()->json(['message' => 'Error can not add new Soal for now'], 404);
    }

    return response()->json(['message' => 'Soal created', 'data' => $matpel], 200);
  }

  /**
   * Delete Soal
   * 
   * @param String $id
   * @return Response
   */
  public function delete($id)
  {
    $this->is_guru();

    $soal = Soal::find($id);
    if (!$soal->delete()) {
      return response()->json(['message' => 'Failed to delete Soal id ' . $id], 400);
    }
    return response()->json(['message' => 'Delete success'], 200);
  }
}
