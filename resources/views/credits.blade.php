<x-app-layout>
    <div class="bg-white rounded-xl px-4 py-3 mb-3 flex gap-2 justify-end items-stretch">
        {{-- <form action="" method="get" class="contents">
            <x-search-input placeholder="Buscar por Cliente o Prestamista" id="search-input" />
        </form> --}}

        <x-danger-button href="{{ route('clients') }}">
            ← Volver
        </x-danger-button>
    </div>

    <div class="bg-white rounded-xl px-4 py-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
            Créditos de {{ $client->name }}
        </h2>


        <!-- Credits List -->
        <div id="creditsList" class="space-y-4 mb-8">
            @foreach ($credits as $credit)
                {{-- dentro del loop usa $loop->index (0-based) o $loop->iteration (1-based) --}}
                @php
                    switch ($credit->status) {
                        case 'pending':
                            $class = 'gradient-yellow';
                            $text = 'Pendiente';
                            break;

                        case 'approved':
                            $class = 'gradient-blue';
                            $text = 'Aprovado';
                            break;

                        case 'rejected':
                            $class = 'gradient-red';
                            $text = 'Rechazado';
                            break;

                        case 'paid':
                            $class = 'gradient-green';
                            $text = 'Pagado';
                            break;

                        default:
                            break;
                    }
                @endphp

                <a href="{{ route('client.payments', $credit) }}"
                    class="{{ $class }} block rounded-xl p-5 sm:p-6 text-white shadow-lg cursor-pointer hover:shadow-xl transition-shadow credit-card">
                    <!-- Versión móvil simplificada -->
                    <div class="block sm:hidden md:block lg:hidden">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold">Credito #{{ $credit->id }}</h3>
                                <p class="text-xs opacity-90 italic">Finaliza el {{ $credit->end_date }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs opacity-90">Monto Total</p>
                                <p class="font-bold text-lg">S/. {{ $credit->amount }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Versión desktop completa -->
                    <div class="hidden sm:flex sm:items-center sm:gap-8 md:hidden lg:flex">
                        <div>
                            <h3 class="text-2xl font-bold">Credito #{{ $credit->id }}</h3>
                            <p class="text-sm opacity-90 italic">Finaliza el {{ $credit->end_date }}</p>
                        </div>

                        <div class="h-12 w-px bg-white/30"></div>

                        <div class="flex gap-6">
                            <div>
                                <p class="text-sm opacity-90">Plazo</p>
                                <p class="font-bold text-base">{{ $credit->term_months }} meses</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Estado</p>
                                <p class="font-bold text-base">
                                    {{ $text }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Saldo Pagado</p>
                                <p class="font-bold text-base">{{ $credit->paid_balance }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-90">Monto Total</p>
                                <p class="font-bold text-base">S/. {{ $credit->amount }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach

            <!-- Credito #3 - Activo (Azul) -->
            {{-- <div class="gradient-blue rounded-xl p-5 sm:p-6 text-white shadow-lg cursor-pointer hover:shadow-xl transition-shadow credit-card"
                data-keywords="credito 3 activo 10/10/2025 2 soles 10 soles">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <!-- Versión móvil simplificada -->
                        <div class="block sm:hidden">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-bold">Credito #3</h3>
                                    <p class="text-xs opacity-90 italic">Finaliza el 10/10/2025</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs opacity-90">Monto Total</p>
                                    <p class="font-bold text-lg">10 Soles</p>
                                </div>
                            </div>
                        </div>

                        <!-- Versión desktop completa -->
                        <div class="hidden sm:flex sm:items-center sm:gap-8">
                            <div>
                                <h3 class="text-2xl font-bold">Credito #3</h3>
                                <p class="text-sm opacity-90 italic">Finaliza el 10/10/2025</p>
                            </div>

                            <div class="h-12 w-px bg-white/30"></div>

                            <div class="flex gap-6">
                                <div>
                                    <p class="text-xs opacity-90">Plazos</p>
                                    <p class="font-bold text-base">2 Días</p>
                                </div>
                                <div>
                                    <p class="text-xs opacity-90">Estado</p>
                                    <p class="font-bold text-base">Activo</p>
                                </div>
                                <div>
                                    <p class="text-xs opacity-90">Saldo Pagado</p>
                                    <p class="font-bold text-base">2 Soles</p>
                                </div>
                                <div>
                                    <p class="text-xs opacity-90">Monto Total</p>
                                    <p class="font-bold text-base">10 Soles</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>


    </div>
</x-app-layout>
