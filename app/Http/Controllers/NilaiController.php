<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\Jawaban;

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

    /**
     * get Jawaban siswa by siswa_id
     *
     * @param $siswa_id
     * @return $nilai_siswa
     */
    public function getSiswa($siswa_id)
    {
        $this->is_guru();

        $nilai_siswa = Jawaban::where('siswa_id', $siswa_id)->with('soals')->with('pilihans')->limit(10)->get();
        return response()->json(['data' => $nilai_siswa]);
    }
}
