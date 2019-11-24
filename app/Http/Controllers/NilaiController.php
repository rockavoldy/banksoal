<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;

class NilaiController extends Controller
{
    /**
     * get Nilai from skor table
     * 
     * @return $siswa
     */
    public function get()
    {
      $this->is_guru();

      $siswa = User::where('roles', 'siswa')->with('skors')->get();
      return response()->json(['data' => $siswa], 200);
    }
}