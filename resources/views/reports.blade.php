<x-app-layout>
    <div class="bg-white rounded-xl px-4 py-8 font-medium">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
            Reportes - Resumen General
        </h2>

        <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-5 items-stretch mb-5">
            <div class="p-5 flex flex-col justify-between border border-gray-300 rounded-lg">
                <h3 class="mb-2">
                    Total de créditos activos
                </h3>
                <span class="text-4xl font-bold">
                    {{ $totalCredits }}
                </span>
            </div>
            <div class="p-5 flex flex-col justify-between border border-gray-300 rounded-lg">
                <h3 class="mb-2">
                    Total de clientes
                </h3>
                <span class="text-4xl font-bold">
                    {{ $clients->total() }}
                </span>
            </div>
            <div class="p-5 flex flex-col justify-between border border-gray-300 rounded-lg">
                <h3 class="mb-2">
                    Créditos vencidos
                </h3>
                <span class="text-4xl font-bold">
                    {{ $dueCredits }}
                </span>
            </div>
            <div class="p-5 flex flex-col justify-between border border-gray-300 rounded-lg">
                <h3 class="mb-2">
                    Pagos recibidos este mes
                </h3>
                <span class="text-4xl font-bold">
                    {{ $totalPayments }}
                </span>
            </div>
        </div>

        <div class="p-3 sm:p-5 border border-gray-300 rounded-lg mb-5">
            <h3 class="mb-2">Créditos otorgados este mes</h3>

            <div class="aspect-square sm:aspect-auto sm:h-[460px]">
                <x-chartjs-component :chart="$chart" />
            </div>
        </div>

        <div class="p-3 sm:p-5 border border-gray-300 rounded-lg">
            <h3 class="mb-2">Reporte de Clientes</h3>
            <div class="relative overflow-x-auto flex">
                <table class="w-full min-w-max text-sm text-left text-gray-800 font-medium">
                    <thead class="text-gray-400 fontP-medium border-b border-gray-200">
                        <tr>
                            <th scope="col" class="p-3 font-medium">Nombre</th>
                            <th scope="col" class="p-3 font-medium">Teléfono</th>
                            <th scope="col" class="p-3 font-medium">Correo electrónico</th>
                            <th scope="col" class="p-3 font-medium">Total de Créditos</th>
                            <th scope="col" class="p-3 font-medium">Total Adeudado</th>
                            <th scope="col" class="p-3 font-medium">Estado</th>
                            <th scope="col" class="p-3 font-medium">Creado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr class="bg-white border-b border-gray-200 filter-item">
                                <td class="px-3 py-4">
                                    {{ $client->name }}
                                </td>
                                <td class="px-3 py-4">
                                    {{ $client->phone }}
                                </td>
                                <td class="px-3 py-4">
                                    {{ $client->email }}
                                </td>
                                <td class="px-3 py-4">
                                    {{ $client->credits->count() }}
                                </td>
                                <td class="px-3 py-4">
                                    S/. {{ number_format($client->credits->sum('amount'), 2, '.', ',') }}
                                </td>
                                <td class="px-3 py-4">
                                    @switch($client->status)
                                        @case('active')
                                            <span
                                                class="bg-green-100 border border-green-700 text-green-800 px-3 py-1 rounded-md">
                                                Activo
                                            </span>
                                        @break

                                        @case('inactive')
                                            <span class="bg-red-100 border border-red-700 text-red-800 px-3 py-1 rounded-md">
                                                Inactivo
                                            </span>
                                        @break

                                        @default
                                    @endswitch
                                </td>
                                <td class="px-3 py-4">
                                    <span class="underline">{{ $client->creator->name }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $clients->links() }}
        </div>

    </div>

</x-app-layout>
