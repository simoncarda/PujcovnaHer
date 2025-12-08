<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

                <!--sidebar-filtry-->
                    <div class="md:col-span-3 bg-gray-50 p-4 shadow">
                        <form method="GET" action="{{ route('dashboard') }}"> <!-- Přidáno form s GET metodou, aby se data dala zasílat do controlleru -->
                            <h3 class="font-bold text-lg mb-4">Filtr her</h3>

                            <div class="mb-4 border-b pb-4">
                                <p class="font-semibold">Kategorie</p>
                                @foreach($kategorie as $kategorie)
                                    <label class="block mt-1">
                                        <input 
                                            type="checkbox" 
                                            name="kat[]" 
                                            value="{{ $kategorie->kategorie_id }}" 
                                            {{-- pokud je kategorie vybrána (takže je v request), checked --}}
                                            @if(in_array($kategorie->kategorie_id, $request->input('kat', []))) 
                                                checked
                                            @endif
                                        > {{ $kategorie->nazev_kategorie }}
                                    </label>
                                @endforeach
                            </div>

                            <div class="mb-4 border-b pb-4">
                                <p class="font-semibold">Počet hráčů</p>
                                {{-- Opět, pokud je hodnota v request, zachová hodnotu --}}
                                <input type="number" name="pocet_hracu" min="1" max="12" class="w-full" value="{{ $request->input('pocet_hracu') }}">
                            </div>

                            <div class="mb-4 border-b pb-4">
                                <p class="font-semibold">Minimální věk hráčů</p>
                                <select name="min_vek" class="w-full" value="{{ $request->input('min_vek', '') }}">
                                    {{-- @selected nastaví "selected" tomu optionu, který splní podmínku, opět pro zachování nastavení řešíme request input --}}
                                    <option value="0" @selected($request->input('min_vek') == 0)>Všechny</option>
                                    @for ($i = 1; $i < 19; $i++)
                                        <option value="{{ $i }}" @selected($request->input('min_vek') == $i)>{{ $i }}+</option>
                                    @endfor
                                </select>
                            </div>

                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-2" type="submit">
                                Filtrovat
                            </button>
                        </form>
                    </div>
                <!--sidebar-filtry konec-->

                <!--body-->
                <div class="md:col-span-9">
                    <div class="bg-white shadow-xl sm:rounded-lg">
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                            <p class="text-gray-500">Zobrazeno {{ $hry->count() }} výsledků</p>
                             <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach ($hry as $hra)
                                    <div class="border p-4 rounded-lg">
                                        <img src="{{ asset($hra->url_obrazku) }}" alt="{{ $hra->nazev }}" class="w-full h-48 object-cover mb-4 rounded">
                                        <a class="text-lg font-bold visited:text-purple-600 hover:underline" href="{{ route('hry.show', ['id' => $hra->hra_id]) }}">{{ $hra->nazev }}</a>
                                        <p class="text-gray-600">{{ $hra->popis }}</p> 

                                        <div class="mt-2">
                                            <form>
                                                <span class="font-bold">Kategorie:</span>
                                                @foreach ($hra->kategorie as $kategorie)
                                                    <span class="bg-blue-100 border border-white text-blue-800 text-xs px-2 py-1 rounded">
                                                        {{ $kategorie->nazev_kategorie }}
                                                    </span>
                                                @endforeach
                                            </form >
                                        </div>
                                        
                                        <div class="mt-2 text-sm text-gray-500">
                                            @if ($hra->kopie->where('stav', 'dostupna')->count() != 0)
                                                <span class="text-green-600 font-bold">Skladem: {{ $hra->kopie->where('stav', 'dostupna')->count() }} ks</span>
                                            @else
                                                <span class="text-red-600 font-bold">Není skladem</span>
                                            @endif
                                        </div>

                                        <div class="mt-2 text-sm text-gray-500">
                                            Počet hráčů: {{ $hra->min_hracu }} - {{ $hra->max_hracu }}
                                        </div>

                                        <div class="mt-2 text-sm text-gray-500">
                                            Věk: od {{ $hra->min_vek }} let
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
