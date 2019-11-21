<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matpel extends Model
{
  use Models\Concerns\UsesUuid;

  protected $fillable = [
    'guru_id', 'name', 'kode_matpel'
  ];

  public function users()
  {
    return $this->belongsTo(User::class, 'guru_id', 'id');
  }
}
