<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    // table name
    protected $table = 'devices';
    // Primary key
    public $primaryKey = 'id';
    // timestamps
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
    }
}
