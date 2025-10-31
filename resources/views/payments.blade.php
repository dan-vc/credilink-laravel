<x-app-layout>
    <div class="bg-white rounded-xl px-4 py-3 mb-3 flex gap-2 justify-end items-stretch">
        {{-- <form action="" method="get" class="contents">
            <x-search-input placeholder="Buscar por Cliente o Prestamista" id="search-input" />
        </form> --}}

        <x-danger-button href="{{ route('client.credits', $credit->client) }}">
            ← Volver
        </x-danger-button>
    </div>

    <div class="bg-white rounded-xl px-4 py-8"  x-data="{ selected: null }>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
            Crédito #{{ $credit->id }}: Pagos de {{ $credit->client->name }}
        </h2>


        <!-- Credit Info Card -->
        <div class="bg-[#003366] rounded-xl p-5 sm:p-6 mb-6 sm:mb-8 text-white shadow-lg">
            <h2 class="text-base sm:text-lg font-semibold mb-4 pb-3 border-b border-white/20">
                Datos de Crédito
            </h2>
            <div class="flex flex-row justify-between flex-wrap gap-4 sm:gap-6">
                <!-- Primera fila -->
                <div>
                    <p class="text-sm opacity-90 mb-1">Interés</p>
                    <p class="font-bold text-sm sm:text-base">{{ number_format($credit->interest_rate, 2) }}%</p>
                </div>
                <div>
                    <p class="text-sm opacity-90 mb-1">Plazos</p>
                    <p class="font-bold text-sm sm:text-base">{{ $credit->term_months }} meses</p>
                </div>
                <div>
                    <p class="text-sm opacity-90 mb-1">Estado</p>
                    <p class="font-bold text-sm sm:text-base">
                        @switch($credit->status)
                            @case('pending')
                                Pendiente
                            @break

                            @case('approved')
                                Aprovado
                            @break

                            @case('rejected')
                                Rechazado
                            @break

                            @case('paid')
                                Pagado
                            @break

                            @default
                        @endswitch
                    </p>
                </div>

                <!-- Segunda fila -->
                <div>
                    <p class="text-sm opacity-90 mb-1">Saldo Pagado</p>
                    <p class="font-bold text-sm sm:text-base">S/. {{ $credit->paid_balance }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm opacity-90 mb-1">Monto Total</p>
                    <p class="font-bold text-sm sm:text-base">S/. {{ $credit->amount }}</p>
                </div>

                <!-- Tercera fila -->
                <div class="col-span-2">
                    <p class="text-sm opacity-90 mb-1">Producto Financiero</p>
                    <p class="font-bold text-sm sm:text-base italic">{{ $credit->product->name }}</p>
                </div>
                <div>
                    <p class="text-sm opacity-90 mb-1">Prestamista</p>
                    <p class="font-bold text-sm sm:text-base italic">{{ $credit->approver->name }}</p>
                </div>

                <!-- Cuarta fila -->
                <div>
                    <p class="text-sm opacity-90 mb-1">Inicio</p>
                    <p class="font-bold text-sm sm:text-base">{{ $credit->start_date }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm opacity-90 mb-1">Finaliza</p>
                    <p class="font-bold text-sm sm:text-base">{{ $credit->end_date }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Cards Grid -->
        <div id="paymentsGrid"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-5">

            @foreach ($payments as $payment)
                @php
                    switch ($payment->status) {
                        case 'pago realizado':
                            $class = 'gradient-green';
                            $text = 'Pago Realizado';
                            break;

                        case 'no pagado':
                            $class = 'gradient-blue';
                            $text = 'No Pagado';
                            break;

                        case 'atrasado':
                            $class = 'gradient-red';
                            $text = 'Atrasado';
                            break;

                        default:
                            break;
                    }
                @endphp

                <div class="{{ $class }} rounded-xl p-5 sm:p-6 text-white shadow-lg payment-card"
                    data-keywords="pago 1 no pagado falta pagar 9/10/2025 1.00">
                    <div class="mb-4">
                        <h3 class="text-lg sm:text-xl font-bold mb-2">Pago {{ $loop->iteration }}</h3>
                        <p class="text-sm opacity-90">Fecha Limite: {{ $payment->due_date }}</p>
                        <p class="text-sm opacity-90">
                            Fecha Pagado: {{ $payment->paid_date ?? 'No disponible' }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <p class="text-3xl sm:text-4xl font-bold">S/ {{ $payment->amount }}</p>
                    </div>

                    <div class="mb-4 space-y-1">
                        <p class="text-sm">
                            <span class="font-semibold">Tipo:</span> <span class="italic">
                                {{ $payment->payment_type ?? 'No pagado' }}
                            </span>
                        </p>
                        <p class="text-sm">
                            <span class="font-semibold">Pago Extra:</span> <span class="italic">
                                {{ 'S/. ' . $payment->extra_payment ?? 'No pagado' }}
                            </span>
                        </p>
                    </div>

                    <div class="flex items-stretch gap-2">
                        <span
                            class="block w-full text-center bg-white text-[#003366] font-semibold py-2.5 px-4 rounded-lg">
                            {{ $text }}
                        </span>

                        <span x-data="" x-on:click.prevent="$dispatch('open-modal', 'pay-payment'); selected = @js($payment)" class="bg-secondary rounded-lg py-2.5 px-4 text-primary font-semibold cursor-pointer">
                            Pagar
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <x-modal name="pay-payment" focusable>
            <form method="post" class="p-6">
                @csrf
                @method('PUT')

                <h2 class="text-xl font-semibold mb-4">
                    Realizar pago
                </h2>

                <x-text-input type="hidden" name="id" required x-bind:value="selected?.id" />

                <!-- Correo Electrónico -->
                <div class="mb-4">
                    <x-input-label for="email" value="Correo Electrónico" class="mb-1" />
                    <x-text-input id="email" class="block w-full" type="email" name="email" required
                        autocomplete="email" placeholder="carlosrv@gmail.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <x-primary-button class="w-full">
                    Añadir Empleado
                </x-primary-button>
            </form>
        </x-modal>
    </div>
</x-app-layout>
