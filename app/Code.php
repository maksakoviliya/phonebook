<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $fillable = ['customer_id', 'phonebook_id', 'users_total', 'code', 'users_count'];

    public function customer()
    {
      return $this->belongsTo('App\Customer');
    }
    public function phonebook()
    {
      return $this->belongsTo('App\PhoneBook');
    }
}
