<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kopie extends Model
{
    use HasFactory;

    protected $table = 'kopie_her';
    protected $primaryKey = 'kopie_id';
    public $timestamps = false;

    protected $fillable = ['hra_id', 'stav'];

    // Vazba k rodiči (Kopie patří jedné Hře)
    public function hra()
    {
        return $this->belongsTo(Hra::class, 'hra_id', 'hra_id');
    }
}