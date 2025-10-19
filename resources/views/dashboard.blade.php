<x-app-layout>
    <div class="bg-white rounded-xl px-4 py-3 mb-3 flex gap-2 justify-between items-stretch">
        <x-search-input placeholder="Buscar por Cliente o Prestamista" id="search-input" />

        <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-new-credit')">
            Generar Crédito
        </x-primary-button>


        <x-modal name="create-new-credit" focusable maxWidth="4xl" :bg="false">
            <div x-data="{products: @js($products), selected: null}" class="flex flex-col items-center gap-5 sm:flex-row">
                <form method="post" action="" class="p-6 bg-white rounded-xl shadow-xl w-full" x-transition>
                    @csrf
                    <h2 class="text-xl font-semibold mb-4">
                        Generar Crédito
                    </h2>

                    <!-- Cliente -->
                    <div class="mb-4">
                        <x-input-label for="client_id" value="Cliente" class="mb-1" />
                        <x-select-input id="client_id" class="block w-full" name="client_id" required
                            autocomplete="client_id">
                            <option value="">Seleccione un cliente</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                    </div>

                    <!-- Producto Financiero -->
                    <div class="mb-4">
                        <x-input-label for="product_id" value="Producto Financiero" class="mb-1" />
                        <x-select-input id="product_id" class="block w-full" name="product_id" required
                            autocomplete="product_id" x-on:change="
                            selected = products.find(p => p.id == $event.target.value) || null">
                            <option value="">Seleccione un producto financiero</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                    </div>

                    <!-- Cantidad -->
                    <div class="mb-4">
                        <x-input-label for="amount" value="Cantidad" class="mb-1" />
                        <div class="flex gap-2">
                            <x-text-input id="amount" class="block w-full" type="number" name="amount" required
                                autocomplete="amount" />

                            <span class="inline-flex items-center bg-gray-200 rounded-md px-4">
                                Soles
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <!-- Fechas -->
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <!-- Fecha Inicial -->
                        <div>
                            <x-input-label for="start_date" value="Fecha Inicial" class="mb-1" />
                            <x-text-input id="start_date" class="block w-full" type="date" name="start_date"
                                required autocomplete="start_date" />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                        <!-- Fecha Final -->
                        <div>
                            <x-input-label for="end_date" value="Fecha Final" class="mb-1" />
                            <x-text-input id="end_date" class="block w-full" type="date" name="end_date"
                                required autocomplete="end_date" />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    <x-primary-button class="w-full">
                        Generar Crédito
                    </x-primary-button>
                </form>

                <!-- Detalles del Producto Financiero -->
                <div class="bg-white rounded-xl shadow-xl w-full sm:max-w-72 px-6 py-3">
                    <h2 class="text-lg font-bold mb-4" x-text="selected?.name ?? 'Seleccione un producto'">
                        Crédito Empresarial
                    </h2>

                    <div class="flex flex-row sm:flex-col gap-2">
                        <!-- Tasa de Interés -->
                        <div class="mb-4">
                            <x-input-label value="Tasa de Interés" class="mb-1" />
                            <x-text-input class="block w-full" type="text" value="12.5" disabled x-bind:value="selected ? selected.interest_rate + '%' : '0%'" />
                        </div>

                        <!-- Pazlo Máximo -->
                        <div class="mb-4">
                            <x-input-label value="Plazo máximo" class="mb-1" />
                            <x-text-input class="block w-full" type="text" value="12 meses" disabled x-bind:value="selected ? selected.max_term_months + ' meses' : 0"/>
                        </div>
                    </div>

                    <!-- Cantidad min-max -->
                    <div class="mb-4">
                        <x-input-label value="Cantidad min - max (S/.)" class="mb-1" />
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <x-text-input class="block w-full" type="number" value="10000" disabled x-bind:value="selected ? selected.min_amount : 0" />
                            <x-text-input class="block w-full" type="number" value="40000" disabled x-bind:value="selected ? selected.max_amount : 0" />
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
    </div>

    <div class="bg-white rounded-xl px-4 py-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
            Créditos
        </h2>

        <div class="relative overflow-x-auto flex">
            <table class="w-full min-w-max text-sm text-left text-gray-800 font-medium">
                <thead class="text-gray-400 fontP-medium border-b border-gray-200">
                    <tr>
                        <th scope="col" class="p-3 font-medium">ID</th>
                        <th scope="col" class="p-3 font-medium">Cliente</th>
                        <th scope="col" class="p-3 font-medium">Plazo</th>
                        <th scope="col" class="p-3 font-medium">Interés</th>
                        <th scope="col" class="p-3 font-medium">Monto Total</th>
                        <th scope="col" class="p-3 font-medium">Prestamista</th>
                        <th scope="col" class="p-3 font-medium">Fecha de Solicitud</th>
                        <th scope="col" class="p-3 font-medium">Fecha de Aprobación</th>
                        <th scope="col" class="p-3 font-medium">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($credits as $credit)
                        <tr class="bg-white border-b border-gray-200 filter-item"
                            data-client="{{ $credit->client->name }}" data-approver="{{ $credit->approver->name }}">
                            <td class="px-3 py-4">
                                {{ $credit->id }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $credit->client->name }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $credit->term_months }}
                            </td>
                            <td class="px-3 py-4">
                                {{ number_format($credit->interest_rate, 2) }}%
                            </td>
                            <td class="px-3 py-4">
                                S/. {{ $credit->amount }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $credit->approver->name }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $credit->start_date }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $credit->end_date }}
                            </td>
                            <td class="px-3 py-4">
                                @switch($credit->status)
                                    @case('approved')
                                        <span class="bg-green-100 border border-green-700 text-green-800 px-3 py-1 rounded-md">
                                            Aprobado
                                        </span>
                                    @break

                                    @case('pending')
                                        <span
                                            class="bg-yellow-100 border border-yellow-700 text-yellow-800 px-3 py-1 rounded-md">
                                            Pendiente
                                        </span>
                                    @break

                                    @case('paid')
                                        <span class="bg-blue-100 border border-blue-700 text-blue-800 px-3 py-1 rounded-md">
                                            Pagado
                                        </span>
                                    @break

                                    @case('rejected')
                                        <span class="bg-red-100 border border-red-700 text-red-800 px-3 py-1 rounded-md">
                                            Rechazado
                                        </span>
                                    @break

                                    @default
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterItems() {
            const searchTerm = (document.getElementById('search-input')?.value || '').trim().toLowerCase();
            const items = document.querySelectorAll('.filter-item');

            items.forEach(item => {
                const client = (item.getAttribute('data-client') || '').toLowerCase();
                const approver = (item.getAttribute('data-approver') || '').toLowerCase();

                // si searchTerm está vacío => todos los items cumplen
                const matchesSearch = !searchTerm || client.includes(searchTerm) || approver.includes(searchTerm);

                matchesSearch ? item.style.display = '' : item.style.display = 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('search-input')?.addEventListener('input', filterItems);
        });
    </script>
</x-app-layout>
