<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory, Translatable; // 2. To add translation methods

    // 3. To define which attributes needs to be translated ايه اللي هيترجم
    public $translatedAttributes= ['name', 'description'];
    protected $fillable= ['name', 'description'];

    public function doctors(){
        return $this->hasMany(Doctor::class);
    }
}
