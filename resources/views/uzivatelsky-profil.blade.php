<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Můj profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

                <!--body-->
                <div class="md:col-span-12">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                            <p class="text-gray-500">Zobrazeno {{ $vypujcky->count() }} výsledků</p>
                             <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                <div class="grid grid-cols-12">
                                    <span class="font-bold col-span-7">Název hry</span>
                                    <span class="font-bold col-span-3">Plánované datum vrácení</span>
                                    <span class="font-bold col-span-2">Akce</span>
                                </div>
                                {{-- Vypíše jen výpůjčky, které jsou aktuální --}}
                                @foreach ($vypujcky as $vypujcka) 
                                    <div class="grid grid-cols-12 border p-4 rounded-lg">
                                        <a class="text-lg font-bold visited:text-purple-600 hover:underline col-span-7" href="{{ route('hry.show', ['id' => $vypujcka->kopie->hra->hra_id]) }}">{{ $vypujcka->kopie->hra->nazev }}</a>

                                        <div class="mt-2 text-sm col-span-3">
                                            {{ $vypujcka->planovane_datum_vraceni ? $vypujcka->planovane_datum_vraceni : 'Čeká na schválení' }}
                                        </div>

                                        <div class="mt-2 text-sm col-span-2">
                                            <form method="POST" action="{{ route('hry.vratit', ['id' => $vypujcka->kopie->kopie_id]) }}">
                                                @csrf
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50 disabled:cursor-not-allowed" {{ ($vypujcka->status_pozadavku) == 'schvaleno' ? '' : 'disabled' }}>
                                                    Vrátit hru
                                                </button>
                                            </form>
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
