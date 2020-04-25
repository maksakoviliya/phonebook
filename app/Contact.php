<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['phonebook_id', 'first_name', 'last_name', 'patronymic', 'position', 'birthday', 'phone1', 'phone2', 'phone3', 'fax', 'email'];

    public function phonebook()
    {
      return $this->belongsTo('App\PhoneBook', 'phonebook_id');
    }
}
