<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $fillable = ['name', 'phone', 'description', 'files_link'];

  public function codes()
  {
    return $this->hasMany('App\Code', 'customer_id');
  }
  public function getCodePhonebooksIdsAttribute()
    {
        return $this->codes->pluck('phonebook_id');
    }
}
