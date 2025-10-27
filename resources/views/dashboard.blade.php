<x-app-layout>
    <div class="bg-white rounded-xl px-4 py-3 mb-3 flex gap-2 justify-between items-stretch">
        <form action="" method="get" class="contents">
            <x-search-input placeholder="Buscar por Cliente o Prestamista" id="search-input" />
        </form>

        <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-new-credit')">
            Generar Crédito
        </x-primary-button>


        <x-modal name="create-new-credit" focusable maxWidth="4xl" :bg="false">
            <div x-data="{ products: @js($products), selected: null }" class="flex flex-col items-center gap-5 sm:flex-row">
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
                            autocomplete="product_id"
                            x-on:change="
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
                            <x-text-input id="amount" class="block w-full" type="number" step="any"
                                name="amount" required autocomplete="amount" />

                            <span class="inline-flex items-center bg-gray-200 rounded-md px-4">
                                Soles
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <!-- Fechas -->
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        @php
                            $today = now('America/Lima')->format('Y-m-d');
                        @endphp
                        <!-- Fecha Inicial -->
                        <div>
                            <x-input-label for="start_date" value="Fecha Inicial" class="mb-1" />
                            <x-text-input id="start_date" class="block w-full" type="date" name="start_date" required
                                autocomplete="start_date" value="{{ $today }}" placeholder="dd/mm/yyyy"
                                disabled />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                        <!-- Fecha Final -->
                        <div>
                            <x-input-label for="end_date" value="Fecha Final" class="mb-1" />
                            <x-text-input id="end_date" class="block w-full" type="date" name="end_date" required
                                autocomplete="end_date" min="{{ $today }}" />
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
                            <x-text-input class="block w-full" type="text" value="12.5" disabled
                                x-bind:value="selected ? selected.interest_rate + '%' : '0%'" />
                        </div>

                        <!-- Pazlo Máximo -->
                        <div class="mb-4">
                            <x-input-label value="Plazo máximo" class="mb-1" />
                            <x-text-input class="block w-full" type="text" value="12 meses" disabled
                                x-bind:value="selected ? selected.max_term_months + ' meses' : 0" />
                        </div>
                    </div>

                    <!-- Cantidad min-max -->
                    <div class="mb-4">
                        <x-input-label value="Cantidad min - max (S/.)" class="mb-1" />
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <x-text-input class="block w-full" type="number" value="10000" disabled
                                x-bind:value="selected ? selected.min_amount : 0" />
                            <x-text-input class="block w-full" type="number" value="40000" disabled
                                x-bind:value="selected ? selected.max_amount : 0" />
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>
    </div>

    <div class="bg-white rounded-xl px-4 py-8" x-data="{ selected: null }">
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
                        <th scope="col" class="p-3 font-medium">Fecha de Finalización</th>
                        <th scope="col" class="p-3 font-medium">Estado</th>
                        {{-- <th scope="col" class="p-3 font-medium">Acciones</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($credits as $credit)
                        <tr class="bg-white border-b border-gray-200 filter-item">
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
                                S/. {{ number_format($credit->amount, 2, '.', ',') }}
                                
                            </td>
                            <td class="px-3 py-4">
                                @if ($credit->approver)
                                    {{ $credit->approver->name }}
                                @else
                                    <span class="italic text-gray-400">Empleado eliminado</span>
                                @endif
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
                            <td class="px-3 py-4">
                                {{-- EDITAR CRÉDITO --}}
                                {{-- <span x-data
                                    x-on:click="$dispatch('open-modal', 'edit-credit'); selected = @js($credit); console.log(selected)"
                                    class="inline-flex border-2 border-orange-300 rounded-md bg-orange-50 px-2 py-1.5 cursor-pointer transition">
                                    <svg width="20" height="20" viewBox="0 0 17 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.1172 10.1836L11.9922 9.30859C12.1289 9.17188 12.375 9.28125 12.375 9.47266V13.4375C12.375 14.1758 11.7734 14.75 11.0625 14.75H1.4375C0.699219 14.75 0.125 14.1758 0.125 13.4375V3.8125C0.125 3.10156 0.699219 2.5 1.4375 2.5H8.90234C9.09375 2.5 9.20312 2.74609 9.06641 2.88281L8.19141 3.75781C8.13672 3.8125 8.08203 3.8125 8.02734 3.8125H1.4375V13.4375H11.0625V10.3477C11.0625 10.293 11.0625 10.2383 11.1172 10.1836ZM15.3828 4.6875L8.21875 11.8516L5.73047 12.125C5.01953 12.207 4.41797 11.6055 4.5 10.8945L4.77344 8.40625L11.9375 1.24219C12.5664 0.613281 13.5781 0.613281 14.207 1.24219L15.3828 2.41797C16.0117 3.04688 16.0117 4.05859 15.3828 4.6875ZM12.7031 5.50781L11.1172 3.92188L6.03125 9.00781L5.8125 10.8125L7.61719 10.5938L12.7031 5.50781ZM14.4531 3.34766L13.2773 2.17188C13.168 2.03516 12.9766 2.03516 12.8672 2.17188L12.0469 2.99219L13.6328 4.60547L14.4805 3.75781C14.5898 3.62109 14.5898 3.45703 14.4531 3.34766Z"
                                            fill="#FFB400" />
                                    </svg>
                                </span> --}}

                                {{-- ELIMINAR CRÉDITO --}}
                                {{-- <span x-data
                                    x-on:click="$dispatch('open-modal', 'confirm-delete-credit'); selected = @js($credit)"
                                    class="inline-flex border-2 border-red-300 rounded-md bg-red-50 px-2 py-1.5 cursor-pointer transition">
                                    <svg width="20" height="20" viewBox="0 0 14 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.20312 12.125C8.01172 12.125 7.875 11.9883 7.875 11.7969V5.89062C7.875 5.72656 8.01172 5.5625 8.20312 5.5625H8.85938C9.02344 5.5625 9.1875 5.72656 9.1875 5.89062V11.7969C9.1875 11.9883 9.02344 12.125 8.85938 12.125H8.20312ZM12.6875 2.9375C12.9062 2.9375 13.125 3.15625 13.125 3.375V3.8125C13.125 4.05859 12.9062 4.25 12.6875 4.25H12.25V13.4375C12.25 14.1758 11.6484 14.75 10.9375 14.75H3.0625C2.32422 14.75 1.75 14.1758 1.75 13.4375V4.25H1.3125C1.06641 4.25 0.875 4.05859 0.875 3.8125V3.375C0.875 3.15625 1.06641 2.9375 1.3125 2.9375H3.55469L4.48438 1.40625C4.70312 1.02344 5.14062 0.75 5.60547 0.75H8.36719C8.83203 0.75 9.26953 1.02344 9.48828 1.40625L10.418 2.9375H12.6875ZM5.55078 2.14453L5.08594 2.9375H8.88672L8.42188 2.14453C8.39453 2.11719 8.33984 2.0625 8.28516 2.0625H5.71484C5.6875 2.0625 5.6875 2.0625 5.6875 2.0625C5.63281 2.0625 5.57812 2.11719 5.55078 2.14453ZM10.9375 13.4375V4.25H3.0625V13.4375H10.9375ZM5.14062 12.125C4.94922 12.125 4.8125 11.9883 4.8125 11.7969V5.89062C4.8125 5.72656 4.94922 5.5625 5.14062 5.5625H5.79688C5.96094 5.5625 6.125 5.72656 6.125 5.89062V11.7969C6.125 11.9883 5.96094 12.125 5.79688 12.125H5.14062Z"
                                            fill="#EB4034" />
                                    </svg>
                                </span> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {{ $credits->links() }}

        <x-modal name="edit-credit" focusable>
            <form method="post" action="" class="p-6 bg-white rounded-xl shadow-xl w-full" x-transition>
                @csrf
                @method('PUT')

                <h2 class="text-xl font-semibold mb-4">
                    Editar Crédito - <span x-text="selected?.id"></span>
                </h2>

                <!-- Cliente -->
                <div class="mb-4">
                    <x-input-label for="client_id" value="Cliente" class="mb-1" />
                    <x-select-input id="client_id" class="block w-full" name="client_id" required
                        autocomplete="client_id" x-bind:value="selected?.client.id">
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
                        autocomplete="product_id"
                        x-on:change="
                            selected = products.find(p => p.id == $event.target.value) || null"
                        x-bind:value="selected?.product.id">
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
                        <x-text-input id="amount" class="block w-full" type="number" step="any"
                            name="amount" required autocomplete="amount" x-bind:value="selected?.amount" />

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
                        <x-text-input id="start_date" class="block w-full" type="date" name="start_date" required
                            autocomplete="start_date" placeholder="dd/mm/yyyy" disabled
                            x-bind:value="selected?.start_date" />
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>
                    <!-- Fecha Final -->
                    <div>
                        <x-input-label for="end_date" value="Fecha Final" class="mb-1" />
                        <x-text-input id="end_date" class="block w-full" type="date" name="end_date" required
                            autocomplete="end_date" min="{{ $today }}" x-bind:value="selected?.end_date" />
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>
                </div>

                <x-primary-button class="w-full">
                    Actualizar Crédito
                </x-primary-button>
            </form>
        </x-modal>
    </div>
</x-app-layout>
