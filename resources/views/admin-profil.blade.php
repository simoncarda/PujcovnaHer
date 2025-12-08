<x-app-layout>
    <x-slot name="header">
       
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

                <!--sidebar-filtry-->
                    <div class="md:col-span-3 bg-gray-50 p-4 shadow">
                        <form method="GET" action="{{ route('admin-profil') }}"> <!-- Přidáno form s GET metodou, aby se data dala zasílat do controlleru -->
                            <h3 class="font-bold text-lg mb-4">Filtr uživatelů</h3>

                            <input 
                                list="users-list" 
                                id="hledani" 
                                name="search_user" 
                                class="border border-gray-300 rounded p-2 w-full mb-4" 
                                placeholder="Začněte psát..."
                                autocomplete="off"
                                value="{{ $request->input('search_user', '') }}"
                            >
                            <div>
                                <datalist id="users-list">
                                    @foreach($uzivatele as $uzivatel)
                                        <option value="{{ $uzivatel->name }}">{{ $uzivatel->name }}</option>
                                    @endforeach
                                </datalist>
                            </div>

                            {{-- Napíše chybu když nenalezne uživatele ve výpůjčkách --}}
                            @if ($selectedUzivatelId === null && $request->filled('search_user')) 
                                <p class="text-red-500 cursor-default">Uživatel nenalezen</p>
                            @endif

                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-2" type="submit">
                                Filtrovat
                            </button>
                        </form>
                    </div>
                <!--sidebar-filtry konec-->

                <!--body-->
                <div class="md:col-span-9">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                            <p class="text-gray-500">Zobrazeno {{ $vypujcky->count() }} výsledků</p>
                             <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                <div class="grid grid-cols-12">
                                    <span class="font-bold col-span-5">Název hry</span>
                                    <span class="font-bold col-span-2">Uživatel</span>
                                    <span class="font-bold col-span-3">Datum žádosti</span>
                                    <span class="font-bold col-span-2">Akce</span>
                                </div>
                                @foreach ($vypujcky as $vypujcka)
                                    <div class="grid grid-cols-12 border p-4 rounded-lg">
                                        <a class="text-lg font-bold visited:text-purple-600 hover:underline col-span-5" href="{{ route('hry.show', ['id' => $vypujcka->kopie->hra->hra_id]) }}">{{ $vypujcka->kopie->hra->nazev }}</a>

                                        <div class="mt-2 text-sm col-span-2">
                                            {{ $vypujcka->uzivatel->name }}
                                        </div>

                                        <div class="mt-2 text-sm col-span-3">
                                            {{ $vypujcka->datum_pozadavku ? $vypujcka->datum_pozadavku : 'Chybí' }}
                                        </div>

                                        <div class="mt-2 text-sm col-span-2">
                                            <form method="POST" action="{{ route('hry.schvalit', ['id' => $vypujcka->kopie->kopie_id]) }}">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                    Schválit
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
