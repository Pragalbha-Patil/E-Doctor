<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorModel extends Model
{
    protected $table = 'doctor_appointment_mapping';
    protected $fillable = [
        'rid','dname','date','time','status',
    ];
}
