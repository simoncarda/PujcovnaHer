<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                <!--Zatím jen příprava-->
                <div class="md:col-span-3 bg-gray-50 p-4 shadow">
                    <h3 class="font-bold text-lg mb-4">Filtr her</h3>

                    <div class="mb-4 border-b pb-4">
                        <p class="font-semibold">Kategorie</p>
                        <label class="block mt-1"><input type="checkbox" name="kat[]" value="strategicke"> Strategické</label>
                        <label class="block mt-1"><input type="checkbox" name="kat[]" value="party"> Párty</label>
                    </div>

                    <div class="mb-4 border-b pb-4">
                        <p class="font-semibold">Minimální hráči</p>
                        <input type="number" min="1" max="10" class="w-full">
                    </div>

                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-2">
                        Filtrovat
                    </button>
                    
                </div>
                
                <!--Zatím jen příprava-->
                <div class="md:col-span-9">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                             <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach ($hry as $hra)
                                    <div class="border p-4 rounded-lg">
                                        <img src="{{ asset($hra->url_obrazku) }}" alt="{{ $hra->nazev }}" class="w-full h-48 object-cover mb-4 rounded">
                                        <a class="text-lg font-bold visited:text-purple-600" href="{{ route('hry.show', ['id' => $hra->hra_id]) }}">{{ $hra->nazev }}</a> <!-- TADY!!! -->
                                        <p class="text-gray-600">{{ $hra->popis }}</p> 

                                        <div class="mt-2">
                                            <span class="font-bold">Kategorie:</span>
                                            @foreach ($hra->kategorie as $kategorie)
                                                <span class="bg-blue-100 border border-white text-blue-800 text-xs px-2 py-1 rounded">
                                                    {{ $kategorie->nazev_kategorie }}
                                                </span>
                                            @endforeach
                                        </div>
                                        
                                        <div class="mt-2 text-sm text-gray-500">
                                            Skladem: {{ $hra->kopie->where('stav', 'dostupna')->count() }} ks
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
