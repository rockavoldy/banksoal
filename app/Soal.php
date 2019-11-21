<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
  use Models\Concerns\UsesUuid;

  protected $fillable = [
    'guru_id', 'matpel_id', 'pertanyaan', 'skor'
  ];

  public function users()
  {
    return $this->belongsTo(User::class, 'guru_id', 'id');
  }

  public function matpels()
  {
    return $this->belongsTo(Matpel::class, 'matpel_id', 'id');
  }
}