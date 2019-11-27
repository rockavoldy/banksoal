<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
  use Models\Concerns\UsesUuid;

  protected $fillable = [
    'siswa_id', 'soal_id', 'pilihan_id', 'is_benar', 'alasan', 'is_alasan_benar'
  ];

  public function users()
  {
    return $this->belongsTo(User::class, 'siswa_id', 'id');
  }

  public function soals()
  {
    return $this->belongsTo(Soal::class, 'soal_id', 'id');
  }

  public function pilihans()
  {
    return $this->belongsTo(Pilihan::class, 'pilihan_id', 'id');
  }
}
