<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kunci extends Model
{
  use Models\Concerns\UsesUuid;

  protected $fillable = [
    'soal_id', 'kunci_id'
  ];

  public function soals()
  {
    return $this->belongsTo(Soal::class, 'soal_id', 'id');
  }

  public function pilihans()
  {
    return $this->belongsTo(Pilihan::class, 'kunci_id', 'id');
  }
}
