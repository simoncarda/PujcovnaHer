<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hra extends Model
{
    use HasFactory;

    protected $table = 'hry';
    protected $primaryKey = 'hra_id';   // Primární klíč
    public $timestamps = false;         // Neřešíme created_at a updated_at

    protected $fillable = ['nazev', 'popis', 'min_hracu', 'max_hracu', 'min_vek', 'url_obrazku'];

    // Vazba M:N (Hra patří do mnoha kategorií)
    public function kategorie()
    {
        return $this->belongsToMany(
            Kategorie::class, 
            'hry_kategorie', // Název propojovací tabulky
            'hra_id',        // Klíč v propojovací tabulce pro hru
            'kategorie_id'   // Klíč v propojovací tabulce pro kategorii
        );
    }

    // Vazba 1:N (Hra bude mít více fyzických kopií)
    public function kopie()
    {
        return $this->hasMany(Kopie::class, 'hra_id', 'hra_id');
    }
}