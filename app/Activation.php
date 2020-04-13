<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    protected $fillable = ['user_id', 'code_id'];


    public function code()
    {
      return $this->belongsTo('App\Code', 'code_id');
    }

}
