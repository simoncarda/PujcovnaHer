<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail hry
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div>
                        <img src="{{ $hra->url_obrazku }}" alt="{{ $hra->nazev }}" class="w-full rounded-lg shadow-md">
                    </div>

                    <div>
                        <h1 class="text-3xl font-bold mb-4">{{ $hra->nazev }}</h1>
                        
                        <div class="mb-4">
                            @foreach ($hra->kategorie as $kategorie)
                                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm mr-2">
                                    {{ $kategorie->nazev_kategorie }}
                                </span>
                            @endforeach
                        </div>

                        <p class="text-gray-600 mb-6 leading-relaxed">
                            {{ $hra->popis }}
                        </p>

                        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                            <div class="bg-blue-50 p-3 rounded">
                                <span class="block text-gray-500">Počet hráčů: </span>
                                <span class="font-bold text-lg">{{ $hra->min_hracu }} - {{ $hra->max_hracu }}</span>
                            </div>
                            <div class="bg-blue-50 p-3 rounded">
                                <span class="block text-gray-500">Doporučený věk:</span>
                                <span class="font-bold text-lg">{{ $hra->min_vek }}+ let</span>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <h3 class="font-bold mb-2">Stav na skladě:</h3>

                            @if(($dostupne = $hra->kopie->where('stav', 'dostupna')->count()) > 0)
                                <span class="text-green-600 font-bold flex items-center">
                                    Skladem ({{ $dostupne }} ks)
                                </span>

                                <form method="POST" action="{{ route('hry.rezervovat', ['id' => $hra->hra_id]) }}">
                                    @csrf <x-button class="mt-4 bg-green-500 hover:bg-green-700">
                                        Rezervovat
                                    </x-button>
                                </form>
                                
                            @else
                                <span class="text-red-600 font-bold">
                                    Momentálně nedostupné
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
                
                {{-- <div class="bg-gray-50 px-6 py-4 border-t">
                    <a href="{{ url()->previous() }}" class="text-gray-600 hover:underline">
                        &larr; Zpět předchozí stránku
                    </a>
                </div> --}}

            </div>
        </div>
    </div>
</x-app-layout>