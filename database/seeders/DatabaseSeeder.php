<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

// Importujeme tvé Modely
use App\Models\User;
use App\Models\Hra;
use App\Models\Kategorie;
use App\Models\Kopie;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Vymazání starých dat
        // Používáme Schema fasádu
        Schema::disableForeignKeyConstraints();
        
        Kopie::truncate();      // Smaže data v tabulce kopie_her

        // Pro pivot tabulku musíme použít DB, protože nemá vlastní Model
        DB::table('hry_kategorie')->truncate(); 
        Kategorie::truncate();  // Smaže data v tabulce kategorie
        Hra::truncate();        // Smaže data v tabulce hry
        User::truncate();       // Smaže data v tabulce uzivatele
        
        Schema::enableForeignKeyConstraints();

        // Vytvoření Uživatelů a Admina přes Model
        echo "Vytvářím uživatele...\n";

        User::create([
            'name' => 'Admin',
            'email' => 'admin@deskovehry.cz',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Petr Novák',
            'email' => 'petr@uzivatel.cz',
            'password' => Hash::make('heslo'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Jana Dvořáková',
            'email' => 'jana@uzivatel.cz',
            'password' => Hash::make('heslo'),
            'is_admin' => false,
        ]);

        // 3. Vytvoření Kategorií přes Model
        echo "Vytvářím kategorie...\n";

        // Uložíme si vytvořené kategorie do proměnných, abychom je mohli snadno přiřazovat
        // Protože jsme dali truncate, ID budou začínat od 1
        $katStrategicke = Kategorie::create(['nazev_kategorie' => 'Strategické']); // ID 1
        $katRodinne     = Kategorie::create(['nazev_kategorie' => 'Rodinné']);     // ID 2
        $katParty       = Kategorie::create(['nazev_kategorie' => 'Párty']);       // ID 3
        $katKaretni     = Kategorie::create(['nazev_kategorie' => 'Karetní']);     // ID 4
        $katNarocne     = Kategorie::create(['nazev_kategorie' => 'Pro náročné']); // ID 5

        // 4. Vytvoření Her a Kopií
        echo "Vytvářím hry a jejich kopie...\n";

        $hryData = [
            [
                'data' => [
                    'nazev' => 'Osadníci z Katanu',
                    'popis' => 'Budujte vesnice, města a cesty na ostrově Katan.',
                    'min_hracu' => 3, 'max_hracu' => 4, 'min_vek' => 10,
                    'url_obrazku' => '/images/Catan.png'
                ],
                'kategorie' => [$katStrategicke->kategorie_id] // Přiřazujeme ID modelu
            ],
            [
                'data' => [
                    'nazev' => 'Carcassonne',
                    'popis' => 'Jednoduchá a chytlavá strategie se stavěním krajiny.',
                    'min_hracu' => 2, 'max_hracu' => 5, 'min_vek' => 7,
                    'url_obrazku' => '/images/Carcassonne.jpg'
                ],
                'kategorie' => [$katStrategicke->kategorie_id]
            ],
            [
                'data' => [
                    'nazev' => 'Krycí jména',
                    'popis' => 'Párty hra se slovy a agenty.',
                    'min_hracu' => 2, 'max_hracu' => 8, 'min_vek' => 10,
                    'url_obrazku' => '/images/KryciJmena.jpg'
                ],
                'kategorie' => [$katParty->kategorie_id]
            ],
            [
                'data' => [
                    'nazev' => 'Dixit',
                    'popis' => 'Hra plná fantazie a krásných ilustrací.',
                    'min_hracu' => 3, 'max_hracu' => 6, 'min_vek' => 8,
                    'url_obrazku' => '/images/Dixit.jpg'
                ],
                'kategorie' => [$katRodinne->kategorie_id]
            ],
            [
                'data' => [
                    'nazev' => 'Ticket to Ride: Europe',
                    'popis' => 'Vydejte se na cestu vlakem po Evropě.',
                    'min_hracu' => 2, 'max_hracu' => 5, 'min_vek' => 8,
                    'url_obrazku' => '/images/TicketToRide.jpg'
                ],
                'kategorie' => [$katStrategicke->kategorie_id]
            ],
            [
                'data' => [
                    'nazev' => 'Bang!',
                    'popis' => 'Divoký západ, přestřelky, šerif a bandité.',
                    'min_hracu' => 4, 'max_hracu' => 7, 'min_vek' => 10,
                    'url_obrazku' => '/images/Bang.svg'
                ],
                // VÍCE kategorií: Párty i Karetní
                'kategorie' => [$katParty->kategorie_id, $katKaretni->kategorie_id]
            ],
            [
                'data' => [
                    'nazev' => 'Dostihy a sázky',
                    'popis' => 'Klasická česká hra s koňmi.',
                    'min_hracu' => 2, 'max_hracu' => 6, 'min_vek' => 10,
                    'url_obrazku' => '/images/DostihyASazky.jpg'
                ],
                'kategorie' => [$katRodinne->kategorie_id]
            ],
            [
                'data' => [
                    'nazev' => 'Dobble',
                    'popis' => 'Postřehová hra pro celou rodinu.',
                    'min_hracu' => 2, 'max_hracu' => 8, 'min_vek' => 6,
                    'url_obrazku' => '/images/Dobble.jpg'
                ],
                'kategorie' => [$katRodinne->kategorie_id]
            ],
            [
                'data' => [
                    'nazev' => 'Scythe',
                    'popis' => 'Komplexní strategie s roboty.',
                    'min_hracu' => 1, 'max_hracu' => 5, 'min_vek' => 14,
                    'url_obrazku' => '/images/Scythe.jpg'
                ],
                'kategorie' => [$katStrategicke->kategorie_id, $katNarocne->kategorie_id]
            ],
            [
                'data' => [
                    'nazev' => 'Activity',
                    'popis' => 'Předvádějte, kreslete, mluvte.',
                    'min_hracu' => 3, 'max_hracu' => 16, 'min_vek' => 12,
                    'url_obrazku' => '/images/Activity.png'
                ],
                'kategorie' => [$katParty->kategorie_id]
            ],
        ];

        foreach ($hryData as $polozka) {
            // Vytvoření hry přes Model
            $hra = Hra::create($polozka['data']);

            // Připojení kategorií (Vazba M:N - belongsToMany)
            // Metoda attach() automaticky zapíše do tabulky 'hry_kategorie'
            $hra->kategorie()->attach($polozka['kategorie']);

            // Vytvoření 3 kopií (Vazba 1:N - hasMany)
            // Metoda createMany() vytvoří více záznamů najednou a automaticky doplní 'hra_id'
            $hra->kopie()->createMany([
                ['stav' => 'dostupna'],
                ['stav' => 'dostupna'],
                ['stav' => 'dostupna'],
            ]);
        }
        
        echo "Hotovo! Databáze byla úspěšně naplněna pomocí Modelů.\n";
    }
}