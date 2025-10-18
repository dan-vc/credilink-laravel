<x-app-layout>
    <div class="bg-white rounded-xl px-4 py-3 mb-3 flex gap-2 justify-between items-stretch">
        <x-search-input placeholder="Buscar..." />

        <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-new-credit')">
            Generar Crédito
        </x-primary-button>


        <x-modal name="create-new-credit" focusable maxWidth="4xl" :bg="false">
            <div class="flex flex-col items-center gap-5 sm:flex-row">
                <form method="post" action="" class="p-6 bg-white rounded-xl shadow-xl w-full">
                    @csrf
                    <h2 class="text-xl font-semibold mb-4">
                        Generar Crédito
                    </h2>

                    <!-- Cliente -->
                    <div class="mb-4">
                        <x-input-label for="cliente" value="Cliente" class="mb-1" />
                        <x-text-input id="cliente" class="block w-full" type="text" name="cliente" required
                            autocomplete="cliente" />
                        <x-input-error :messages="$errors->get('cliente')" class="mt-2" />
                    </div>

                    <!-- Producto Financiero -->
                    <div class="mb-4">
                        <x-input-label for="producto_financiero" value="Producto Financiero" class="mb-1" />
                        <x-text-input id="producto_financiero" class="block w-full" type="text"
                            name="producto_financiero" required autocomplete="producto_financiero" />
                        <x-input-error :messages="$errors->get('producto_financiero')" class="mt-2" />
                    </div>

                    <!-- Cantidad -->
                    <div class="mb-4">
                        <x-input-label for="cantidad" value="Cantidad" class="mb-1" />
                        <div class="flex gap-2">
                            <x-text-input id="cantidad" class="block w-full" type="number" name="cantidad" required
                                autocomplete="cantidad" />

                            <span class="inline-flex items-center bg-gray-200 rounded-md px-4">
                                Soles
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
                    </div>

                    <!-- Fechas -->
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <!-- Fecha Inicial -->
                        <div>
                            <x-input-label for="fecha_inicial" value="Fecha Inicial" class="mb-1" />
                            <x-text-input id="fecha_inicial" class="block w-full" type="date" name="fecha_inicial"
                                required autocomplete="fecha_inicial" />
                            <x-input-error :messages="$errors->get('fecha_inicial')" class="mt-2" />
                        </div>
                        <!-- Fecha Final -->
                        <div>
                            <x-input-label for="fecha_final" value="Fecha Final" class="mb-1" />
                            <x-text-input id="fecha_final" class="block w-full" type="date" name="fecha_final"
                                required autocomplete="fecha_final" />
                            <x-input-error :messages="$errors->get('fecha_final')" class="mt-2" />
                        </div>
                    </div>

                    <x-primary-button class="w-full">
                        Generar Crédito
                    </x-primary-button>
                </form>

                <!-- Detalles del Producto Financiero -->
                <div class="bg-white rounded-xl shadow-xl w-full sm:max-w-72 px-6 py-3">
                    <h2 class="text-lg font-bold mb-4">
                        Crédito Empresarial
                    </h2>

                    <div class="flex flex-row sm:flex-col gap-2">
                        <!-- Tasa de Interés -->
                        <div class="mb-4">
                            <x-input-label value="Tasa de Interés" class="mb-1" />
                            <x-text-input class="block w-full" type="text" value="12.5" disabled />
                        </div>

                        <!-- Pazlo Máximo -->
                        <div class="mb-4">
                            <x-input-label value="Plazo máximo" class="mb-1" />
                            <x-text-input class="block w-full" type="text" value="12 meses" disabled />
                        </div>
                    </div>

                    <!-- Cantidad min-max -->
                    <div class="mb-4">
                        <x-input-label value="Cantidad S/min - max" class="mb-1" />
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <x-text-input class="block w-full" type="number" value="10000" disabled />
                            <x-text-input class="block w-full" type="number" value="40000" disabled />
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
                    <tr class="bg-white border-b border-gray-200">
                        <td class="px-3 py-4">
                            C-0001
                        </td>
                        <td class="px-3 py-4">
                            Jane Cooper
                        </td>
                        <td class="px-3 py-4">
                            12 meses
                        </td>
                        <td class="px-3 py-4">
                            10%
                        </td>
                        <td class="px-3 py-4">
                            S/. 3000.00
                        </td>
                        <td class="px-3 py-4">
                            Junior Ynga
                        </td>
                        <td class="px-3 py-4">
                            16/05/25
                        </td>
                        <td class="px-3 py-4">
                            10/10/25
                        </td>
                        <td class="px-3 py-4">
                            <span class="bg-green-100 border border-green-700 text-green-800 px-3 py-1 rounded-md">
                                Aprobado
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
