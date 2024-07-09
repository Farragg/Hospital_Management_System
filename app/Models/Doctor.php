<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasFactory, Translatable;

    public $translatedAttributes  = ['name', 'appointments'];
    public $fillable = [
        'email',
        'email_verified_at',
        'password',
        'phone',
        'name',
        'section_id',
        'status',
        'number_of_statements'
    ];

    //Get The Doctor Image

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }
    public function section(){
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function doctorappointments(){
        return $this->belongsToMany(Appointment::class, 'appointment_doctor');
    }
}
