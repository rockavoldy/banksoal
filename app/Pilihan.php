<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pilihan extends Model
{
  use Models\Concerns\UsesUuid;

  protected $fillable = [
    'soal_id', 'pilihan'
  ];

  public function soals()
  {
    return $this->belongsTo(Soal::class, 'soal_id', 'id');
  }
}
