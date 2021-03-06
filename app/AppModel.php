<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'uid';
    protected $fillable = [
        'uid','uname','uemail','umobile','ugender','adate','atime','atoken',
    ];
}