<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vypujcka extends Model
{
    use HasFactory;

    protected $table = 'vypujcky';
    protected $primaryKey = 'vypujcka_id';
    public $timestamps = false; // nevyužíváme created_at a updated_at

    protected $fillable = [
        'uzivatel_id', 
        'kopie_id', 
        'status_pozadavku', 
        'datum_pozadavku', 
        'planovane_datum_vraceni', 
        'skutecne_datum_vraceni'
    ];

    // Vypůjčka patří uživateli
    public function uzivatel()
    {
        return $this->belongsTo(User::class, 'uzivatel_id', 'uzivatel_id');
    }

    // Vypůjčka se vztahuje ke konkrétní kopii
    public function kopie()
    {
        return $this->belongsTo(Kopie::class, 'kopie_id', 'kopie_id');
    }
}