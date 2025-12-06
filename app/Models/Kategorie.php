<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategorie extends Model
{
    use HasFactory;

    protected $table = 'kategorie';
    protected $primaryKey = 'kategorie_id';
    public $timestamps = false;

    protected $fillable = ['nazev_kategorie'];

    // Kategorie má mnoho her (Vazba M:N)
    public function hry()
    {
        return $this->belongsToMany(
            Hra::class, 
            'hry_kategorie', 
            'kategorie_id', 
            'hra_id'
        );
    }
}