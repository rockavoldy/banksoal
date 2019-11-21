<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skor extends Model
{
  use Models\Concerns\UsesUuid;

  protected $fillable = [
    'siswa_id', 'benar', 'skor', 'waktu'
  ];

  public function users()
  {
    return $this->belongsTo(User::class, 'siswa_id', 'id');
  }
}
