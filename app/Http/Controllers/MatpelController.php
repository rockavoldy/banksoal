<?php

namespace App\Http\Controllers;

use App\Matpel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatpelController extends Controller
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
   * Get all matpel
   * 
   * @return Response
   */
  public function getAll()
  {
    $matpels = Matpel::get();
    return response()->json(['data' => $matpels], 200);
  }

  /**
   * Get one matpel using kode
   * 
   * @param String $kode
   * @return Response
   */
  public function getOne($kode)
  {
    $matpel = Matpel::where('kode_matpel', $kode)->first();

    if (!$matpel) {
      return response()->json(['message' => 'No data'], 404);
    }
    return response()->json(['data' => $matpel], 200);
  }

  /**
   * Insert new Matpel
   * 
   * @param Request $request
   * @return Response
   */
  public function add(Request $request)
  {
    $this->is_guru();

    $this->validate($request, [
      'name' => 'required',
      'kode_matpel' => 'required|unique:matpels'
    ]);

    $matpel = new Matpel();
    $matpel->guru_id = Auth::user()->id;
    $matpel->name = $request->name;
    $matpel->kode_matpel = $request->kode_matpel;

    if (!$matpel->save()) {
      return response()->json(['message' => 'Error can not add new Matpel for now'], 404);
    }

    return response()->json(['message' => 'Matpel created', 'data' => $matpel], 200);
  }

  /**
   * Delete Matpel
   * 
   * @param Request $request
   * @return Response
   */
  public function delete($kode)
  {
    $this->is_guru();

    $matpel = Matpel::where('kode_matpel', $kode);
    if (!$matpel->delete()) {
      return response()->json(['message' => 'Failed to delete kode mata pelajaran ' . $kode], 400);
    }
    return response()->json(['message' => 'Delete success'], 200);
  }
}
