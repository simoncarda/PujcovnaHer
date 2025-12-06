<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seznam deskových her') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($hry as $hra)
                        <div class="border p-4 rounded-lg">
                            <h3 class="text-lg font-bold">{{ $hra->nazev }}</h3>
                            <p class="text-gray-600">{{ $hra->popis }}</p>
                            
                            <div class="mt-2">
                                <span class="font-bold">Kategorie:</span>
                                @foreach ($hra->kategorie as $kategorie)
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                        {{ $kategorie->nazev_kategorie }}
                                    </span>
                                @endforeach
                            </div>
                            
                            <div class="mt-2 text-sm text-gray-500">
                                Skladem: {{ $hra->kopie->where('stav', 'dostupna')->count() }} ks
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>