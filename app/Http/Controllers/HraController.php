<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hra;
use App\Models\Kategorie;

class HraController extends Controller
{
    public function index()
    {
        $kategorie = Kategorie::with('hry')->get(); // Načtení kategorií, které obsahují hry
        $hry = Hra::with('kategorie', 'kopie')->get(); // Vyhledání her s kategoriemi a kopiemi

        return view('hry.index', [
            'hry' => $hry, 
            'kategorie' => $kategorie,
        ]);
    }

    public function pageDashboard(Request $request)
    {
        $kategorie = Kategorie::with('hry')->get();
        
        // Filtrace podle kategorií, počtu hráčů a minimálního věku
        $query = Hra::with('kategorie', 'kopie'); // Query pro vyhledání her s kategoriemi a kopiemi (dále budeme modifikvat podle filtrů)
        $selectedKategorie = $request->input('kat', []); // Získání vybraných kategorií z requestu

        if (!empty($selectedKategorie)) { //pokud jsou vybrané nějaké kategorie
            $query->whereHas('kategorie', function($q) use ($selectedKategorie){ 
                $q->whereIn('kategorie.kategorie_id', $selectedKategorie);
            });
        }
        $pocetHracu = $request->input('pocet_hracu');
        if ($pocetHracu > 0) {
            $query->where('min_hracu', '<=', $pocetHracu)
                  ->where('max_hracu', '>=', $pocetHracu);
        }
        if ($request->filled('min_vek')) {
            $minVek = $request->input('min_vek');
            if ($minVek > 0) {
                $query->where('min_vek', '>=', $minVek);
            }
        }

        $hry = $query->get();

        return view('dashboard', [
            'hry' => $hry, 
            'kategorie' => $kategorie,
            'request' => $request,
        ]);
    }
    public function show($id)
    {
        $hra = Hra::with('kategorie', 'kopie')->findOrFail($id);
        return view('hry.show', ['hra' => $hra]);
    }
}
