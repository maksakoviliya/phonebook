<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneBook extends Model
{
    
    protected $fillable = ['title', 'full_name', 'description', 'parent_id', 'contacts', 'site', 'address', 'email'];
    protected $casts = ['contacts' => 'json'];

    public function phonebooks()
    {
      return $this->hasMany('App\PhoneBook', 'parent_id');
    }
    public function childrenPhonebooks()
    {
      return $this->hasMany('App\PhoneBook', 'parent_id')->with('phonebooks');
    }
    public function phonebook()
    {
      return $this->belongsTo('App\PhoneBook', 'parent_id');
    }
    public function codes()
    {
      return $this->hasMany('App\Code', 'phonebook_id');
    }
    public function contacts()
    {
      return $this->hasMany('App\Contact', 'phonebook_id');
    }
}
