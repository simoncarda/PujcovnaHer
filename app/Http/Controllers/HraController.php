<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hra;
use App\Models\Kategorie;
use App\Models\Kopie;
use App\Models\Vypujcka;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    // Rezervace hry
    public function rezervovat($id)
    {
        $userID = Auth::id(); // Získání ID přihlášeného uživatele
        $kopie = Kopie::where('hra_id', $id) // Vyhledání první dostupné kopie hry
            ->where('stav', 'dostupna')
            ->first();
        
        DB::transaction(function () use ($kopie, $userID) {
            // Aktualizace stavu kopie na 'rezervovana'
            $kopie->stav = 'nedostupna';
            $kopie->save();

            // Vytvoření záznamu o rezervaci
            Vypujcka::create([
                'uzivatel_id' => $userID,
                'kopie_id' => $kopie->kopie_id,
                'status_pozadavku' => 'ceka_na_schvaleni',
                'datum_pozadavku' => now(),
            ]);
        });

        return redirect()->route('hry.show', ['id' => $kopie->hra_id])->with('success', 'Hra byla úspěšně rezervována.'); // Přesměrování zpět na stránku hry s úspěšnou zprávou
    }

    public function uzivatelskyProfil()
    {
        $vypujcky = Vypujcka::where('uzivatel_id', Auth::id())
            ->where('status_pozadavku', '!=', 'vraceno') // Zobrazení jen aktuálních výpůjček
            ->where('skryto', false) //Zobrazení pouze záznamů, které uživatel neskryl
            ->with('kopie.hra') // Načtení související hry přes kopii
            ->get();

        return view('uzivatelsky-profil', [
            'vypujcky' => $vypujcky,
        ]);
    }
    public function adminProfil(Request $request)
    {
        $vypujcky = Vypujcka::with('kopie.hra', 'uzivatel')
            ->where('status_pozadavku', 'ceka_na_schvaleni');
        $uzivatele = User::all();
        
        // Filtrace podle uživatele
        $selectedUzivatel = $request->input('search_user', ''); // vyhodí jen jmeno uživatele
        $selectedUzivatelId = $uzivatele->firstWhere('name', $selectedUzivatel)?->uzivatel_id; //pokud uživatel toho jména existuje, vyhoď jeho ID
        if (!empty($selectedUzivatelId)) {
            $vypujcky->where('uzivatel_id', $selectedUzivatelId); // filtrace vypujcek podle uživatele
        }

        $vypujcky = $vypujcky->get();

        return view('admin-profil', [
            'selectedUzivatelId' => $selectedUzivatelId,
            'vypujcky' => $vypujcky,
            'uzivatele' => $uzivatele,
            'request' => $request,
        ]);
    }

    public function schvalit($id)
    {
        $vypujcka = Vypujcka::where('kopie_id', $id) // Vyhledání výpůjčky podle ID kopie
            ->where('status_pozadavku', 'ceka_na_schvaleni')
            ->firstOrFail();

        DB::transaction(function () use ($vypujcka) {
            // Aktualizace stavu výpůjčky na 'schvaleno'
            $vypujcka->status_pozadavku = 'schvaleno';
            $vypujcka->planovane_datum_vraceni = now()->addDays(30); // Nastavení plánovaného data vrácení na 30 dní od schválení
            $vypujcka->save();
        });

        return redirect()->route('admin-profil')->with('success', 'Výpůjčka byla úspěšně schválena.'); // Přesměrování zpět na admin profil s úspěšnou zprávou
    }

    public function vratit($id)
    {
        $vypujcka = Vypujcka::where('kopie_id', $id) // Vyhledání výpůjčky podle ID kopie
            ->where('status_pozadavku', 'schvaleno')
            ->firstOrFail();
        DB::transaction(function () use ($vypujcka) {
            // Aktualizace stavu výpůjčky
            $vypujcka->skutecne_datum_vraceni = now(); // Nastavení data vrácení na aktuální datum
            $vypujcka->status_pozadavku = 'vraceno';
            $vypujcka->save();
            // Aktualizace stavu kopie na 'dostupna'
            $kopie = $vypujcka->kopie;
            $kopie->stav = 'dostupna';
            $kopie->save();
        });
        return redirect()->route('uzivatelsky-profil')->with('success', 'Výpůjčka byla úspěšně vrácena.'); // Přesměrování zpět na uživatelský profil s úspěšnou zprávou
    }

    public function zamitnout($id)
    {
        $vypujcka = Vypujcka::where('kopie_id', $id) // Vyhledání výpůjčky podle ID kopie
            ->where('status_pozadavku', 'ceka_na_schvaleni')
            ->firstOrFail();

        DB::transaction(function () use ($vypujcka) {
            // Aktualizace stavu výpůjčky na 'zamitnuto'
            $vypujcka->status_pozadavku = 'zamitnuto';
            $vypujcka->planovane_datum_vraceni = null;
            $vypujcka->save();

            // kopie -> znovu dostupná
            $kopie = $vypujcka->kopie;
            $kopie->stav = 'dostupna';
            $kopie->save();
        });

        return redirect()->route('admin-profil')->with('success', 'Výpůjčka byla úspěšně zamítnuta.'); // Přesměrování zpět na admin profil s úspěšnou zprávou
    }

    public function skryt($id)
    {
        $vypujcka = Vypujcka::where('kopie_id', $id)
            ->where('uzivatel_id', Auth::id())
            ->firstOrFail();

        $vypujcka->skryto = true;
        $vypujcka->save();

        return redirect()
            ->route('uzivatelsky-profil')
            ->with('success', 'Záznam byl skryt.');
    }

}
