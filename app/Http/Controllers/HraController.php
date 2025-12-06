<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hra;

class HraController extends Controller
{
    public function index()
    {
        return view('hry.index', ['hry' => $this->getHryWithKategorieKopie()]);
    }

    public function pageDashboard()
    {
        return view('dashboard', ['hry' => $this->getHryWithKategorieKopie()]);
    }

    public function getHryWithKategorieKopie()
    {
        $hry = Hra::with('kategorie', 'kopie')->get();
        return $hry;    
    }

    public function show($id)
    {
        $hra = Hra::with('kategorie', 'kopie')->findOrFail($id);
        return view('hry.show', ['hra' => $hra]);
    }
}
