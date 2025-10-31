<x-app-layout>
    <div class="bg-white rounded-xl px-4 py-3 mb-3 flex gap-2 justify-between items-stretch">
        <form action="" method="get" class="contents">
            <x-search-input placeholder="Buscar..." id="search-input" />
        </form>

        <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-new-user')">
            Añadir Cliente
        </x-primary-button>

        <x-modal name="create-new-user" focusable>
            <form method="post" action="" class="p-6">
                @csrf
                <h2 class="text-xl font-semibold mb-4">
                    Añadir Nuevo Cliente
                </h2>

                <!-- Nombre -->
                <div class="mb-4">
                    <x-input-label for="name" value="Nombre" class="mb-1" />
                    <x-text-input id="name" class="block w-full" type="text" name="name" required
                        autocomplete="name" placeholder="Juancito Perez" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Teléfono -->
                <div class="mb-4">
                    <x-input-label for="phone" value="Teléfono" class="mb-1" />
                    <x-text-input id="phone" class="block w-full" type="tel" name="phone" required
                        autocomplete="phone" placeholder="945123547" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Correo Electrónico -->
                <div class="mb-4">
                    <x-input-label for="email" value="Correo Electrónico" class="mb-1" />
                    <x-text-input id="email" class="block w-full" type="email" name="email" required
                        autocomplete="email" placeholder="juanpe@gmail.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Estado -->
                <div class="mb-4">
                    <x-input-label for="status" value="Estado" class="mb-1" />
                    <x-select-input id="status" class="block w-full" name="status" required autocomplete="status">
                        <option value="">Seleccione un estado</option>
                        <option value="active">Activado</option>
                        <option value="inactive">Desactivado</option>
                    </x-select-input>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <!-- Tipo de Cliente -->
                <div class="mb-4">
                    <x-input-label for="type" value="Tipo de Cliente" class="mb-1" />
                    <x-select-input id="type" class="block w-full" name="type" required autocomplete="type">
                        <option value="">Seleccione un tipo</option>
                        <option value="empresa">Empresa</option>
                        <option value="cliente">Cliente</option>
                    </x-select-input>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <x-primary-button class="w-full">
                    Añadir Cliente
                </x-primary-button>
            </form>
        </x-modal>
    </div>

    <div class="bg-white rounded-xl px-4 py-8" x-data="{ selected: null }">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
            Clientes
        </h2>

        <div class="relative overflow-x-auto flex">
            <table class="w-full min-w-max text-sm text-left text-gray-800 font-medium">
                <thead class="text-gray-400 fontP-medium border-b border-gray-200">
                    <tr>
                        <th scope="col" class="p-3 font-medium">ID</th>
                        <th scope="col" class="p-3 font-medium">Nombre</th>
                        <th scope="col" class="p-3 font-medium">Teléfono</th>
                        <th scope="col" class="p-3 font-medium">Correo Electrónico</th>
                        <th scope="col" class="p-3 font-medium">Fecha de Creación</th>
                        <th scope="col" class="p-3 font-medium">Fecha de Actualización</th>
                        <th scope="col" class="p-3 font-medium">Estado</th>
                        <th scope="col" class="p-3 font-medium">Tipo</th>
                        <th scope="col" class="p-3 font-medium">Creado por</th>
                        <th scope="col" class="p-3 font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr class="bg-white border-b border-gray-200 filter-item">
                            <td class="px-3 py-4">
                                {{ $client->id }}
                            </td>
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
                                {{ $client->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $client->updated_at->format('Y-m-d') }}
                            </td>
                            <td class="px-3 py-4">
                                @switch($client->status)
                                    @case('active')
                                        <span class="bg-green-100 border border-green-700 text-green-800 px-3 py-1 rounded-md">
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
                                @switch($client->type)
                                    @case('empresa')
                                        <span class="bg-blue-100 border border-blue-700 text-blue-800 px-3 py-1 rounded-md">
                                            Empresa
                                        </span>
                                    @break

                                    @case('cliente')
                                        <span
                                            class="bg-orange-100 border border-orange-700 text-orange-800 px-3 py-1 rounded-md">
                                            Cliente
                                        </span>
                                    @break

                                    @default
                                @endswitch
                            </td>
                            <td class="px-3 py-4">
                                {{ $client->creator->name }}
                            </td>
                            <td class="px-3 py-4">
                                <span x-data
                                    x-on:click="$dispatch('open-modal', 'edit-client'); selected = @js($client)"
                                    class="inline-flex border-2 border-orange-300 rounded-md bg-orange-50 px-2 py-1.5 cursor-pointer transition">
                                    <svg width="20" height="20" viewBox="0 0 17 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.1172 10.1836L11.9922 9.30859C12.1289 9.17188 12.375 9.28125 12.375 9.47266V13.4375C12.375 14.1758 11.7734 14.75 11.0625 14.75H1.4375C0.699219 14.75 0.125 14.1758 0.125 13.4375V3.8125C0.125 3.10156 0.699219 2.5 1.4375 2.5H8.90234C9.09375 2.5 9.20312 2.74609 9.06641 2.88281L8.19141 3.75781C8.13672 3.8125 8.08203 3.8125 8.02734 3.8125H1.4375V13.4375H11.0625V10.3477C11.0625 10.293 11.0625 10.2383 11.1172 10.1836ZM15.3828 4.6875L8.21875 11.8516L5.73047 12.125C5.01953 12.207 4.41797 11.6055 4.5 10.8945L4.77344 8.40625L11.9375 1.24219C12.5664 0.613281 13.5781 0.613281 14.207 1.24219L15.3828 2.41797C16.0117 3.04688 16.0117 4.05859 15.3828 4.6875ZM12.7031 5.50781L11.1172 3.92188L6.03125 9.00781L5.8125 10.8125L7.61719 10.5938L12.7031 5.50781ZM14.4531 3.34766L13.2773 2.17188C13.168 2.03516 12.9766 2.03516 12.8672 2.17188L12.0469 2.99219L13.6328 4.60547L14.4805 3.75781C14.5898 3.62109 14.5898 3.45703 14.4531 3.34766Z"
                                            fill="#FFB400" />
                                    </svg>
                                </span>

                                <span x-data
                                    x-on:click="$dispatch('open-modal', 'confirm-delete-client'); selected = @js($client)"
                                    class="inline-flex border-2 border-red-300 rounded-md bg-red-50 px-2 py-1.5 cursor-pointer transition 
                                    @if ($client->status === 'inactive') opacity-50 pointer-events-none @endif">
                                    <svg width="20" height="20" viewBox="0 0 22 19" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.875 6H11.0156C11.8281 6 12.5312 6.29688 13.125 6.89062C13.7188 7.48438 14.0156 8.1875 14.0156 9V9.1875L10.875 6ZM6.5625 6.79688C6.1875 7.54688 6 8.28125 6 9C6 10.375 6.48438 11.5625 7.45312 12.5625C8.45312 13.5312 9.64062 14.0156 11.0156 14.0156C11.7344 14.0156 12.4688 13.8281 13.2188 13.4531L11.6719 11.9062C11.4219 11.9688 11.2031 12 11.0156 12C10.2031 12 9.5 11.7031 8.90625 11.1094C8.3125 10.5156 8.01562 9.8125 8.01562 9C8.01562 8.8125 8.04688 8.59375 8.10938 8.34375L6.5625 6.79688ZM1.03125 1.26562L2.29688 0L20.0156 17.7188L18.75 18.9844C18.5938 18.8281 18.0938 18.3438 17.25 17.5312C16.4375 16.7188 15.8125 16.0938 15.375 15.6562C14.0312 16.2188 12.5781 16.5 11.0156 16.5C8.54688 16.5 6.3125 15.8125 4.3125 14.4375C2.3125 13.0625 0.875 11.25 0 9C0.34375 8.1875 0.875 7.29688 1.59375 6.32812C2.34375 5.32812 3.0625 4.5625 3.75 4.03125C3.375 3.65625 2.84375 3.125 2.15625 2.4375C1.5 1.75 1.125 1.35938 1.03125 1.26562ZM11.0156 3.98438C10.3906 3.98438 9.78125 4.10938 9.1875 4.35938L7.03125 2.20312C8.25 1.73438 9.57812 1.5 11.0156 1.5C13.4844 1.5 15.7031 2.1875 17.6719 3.5625C19.6719 4.9375 21.1094 6.75 21.9844 9C21.2344 10.8438 20.0938 12.4219 18.5625 13.7344L15.6562 10.8281C15.9062 10.2344 16.0312 9.625 16.0312 9C16.0312 7.625 15.5312 6.45312 14.5312 5.48438C13.5625 4.48438 12.3906 3.98438 11.0156 3.98438Z"
                                            fill="#EB4034" />
                                    </svg>
                                </span>

                                <a href="{{ route('client.credits', $client) }}"
                                    class="inline-flex border-2 border-primary rounded-md bg-[#00336620] px-2 py-1.5 cursor-pointer transition">
                                    <svg width="20" height="20" viewBox="0 0 16 11" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.875 2.1875V2.21484C9.57031 2.21484 10.9375 3.58203 10.9375 5.25C10.9375 6.94531 9.57031 8.3125 7.875 8.3125C6.17969 8.3125 4.8125 6.94531 4.8125 5.25C4.8125 4.94922 4.86719 4.67578 4.94922 4.40234C5.14062 4.53906 5.41406 4.59375 5.6875 4.59375C6.50781 4.59375 7.21875 3.91016 7.21875 3.0625C7.19141 2.81641 7.13672 2.54297 7 2.32422C7.27344 2.24219 7.57422 2.21484 7.875 2.1875ZM15.6406 4.86719C15.6953 4.97656 15.7227 5.11328 15.7227 5.27734C15.7227 5.41406 15.6953 5.55078 15.6406 5.66016C14.1641 8.55859 11.2109 10.5 7.875 10.5C4.51172 10.5 1.55859 8.55859 0.0820312 5.66016C0.0273438 5.55078 0 5.41406 0 5.25C0 5.11328 0.0273438 4.97656 0.0820312 4.86719C1.55859 1.96875 4.51172 0 7.875 0C11.2109 0 14.1641 1.96875 15.6406 4.86719ZM7.875 9.1875C10.5547 9.1875 13.043 7.68359 14.3555 5.25C13.043 2.81641 10.5547 1.3125 7.875 1.3125C5.16797 1.3125 2.67969 2.81641 1.36719 5.25C2.67969 7.68359 5.16797 9.1875 7.875 9.1875Z"
                                            fill="#003366" />
                                    </svg>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $clients->links() }}

        <x-modal name="edit-client" focusable>
            <form method="post" action="" class="p-6">
                @csrf
                @method('PUT')

                <h2 class="text-xl font-semibold mb-4">
                    Editar Empleado - <span x-text="selected?.name"></span>
                </h2>

                <x-text-input type="hidden" name="id" required x-bind:value="selected?.id" />

                <!-- Nombre -->
                <div class="mb-4">
                    <x-input-label for="name" value="Nombre" class="mb-1" />
                    <x-text-input id="name" class="block w-full" type="text" name="name" required
                        autocomplete="name" placeholder="Juancito Perez" x-bind:value="selected?.name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Teléfono -->
                <div class="mb-4">
                    <x-input-label for="phone" value="Teléfono" class="mb-1" />
                    <x-text-input id="phone" class="block w-full" type="tel" name="phone" required
                        autocomplete="phone" placeholder="945123547" x-bind:value="selected?.phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Correo Electrónico -->
                <div class="mb-4">
                    <x-input-label for="email" value="Correo Electrónico" class="mb-1" />
                    <x-text-input id="email" class="block w-full" type="email" name="email" required
                        autocomplete="email" placeholder="juanpe@gmail.com" x-bind:value="selected?.email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Estado -->
                <div class="mb-4">
                    <x-input-label for="status" value="Estado" class="mb-1" />
                    <x-select-input id="status" class="block w-full" name="status" required
                        autocomplete="status" x-bind:value="selected?.status">
                        <option value="">Seleccione un estado</option>
                        <option value="active">Activado</option>
                        <option value="inactive">Desactivado</option>
                    </x-select-input>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <!-- Tipo de Cliente -->
                <div class="mb-4">
                    <x-input-label for="type" value="Tipo de Cliente" class="mb-1" />
                    <x-select-input id="type" class="block w-full" name="type" required autocomplete="type"
                        x-bind:value="selected?.type">
                        <option value="">Seleccione un tipo</option>
                        <option value="empresa">Empresa</option>
                        <option value="cliente">Cliente</option>
                    </x-select-input>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <x-primary-button class="w-full">
                    Actualizar Empleado
                </x-primary-button>
            </form>
        </x-modal>

        <x-modal name="confirm-delete-client" focusable>
            <form method="post" action="" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-xl font-semibold mb-2">
                    ¿Estás seguro de que deseas desactivar el cliente <span class="font-bold italic"
                        x-text="selected?.name"></span>?
                </h2>

                <x-text-input type="hidden" name="id" required x-bind:value="selected?.id" />

                <x-danger-button class="w-full">
                    Desactivar Cliente
                </x-danger-button>
            </form>
        </x-modal>
    </div>
</x-app-layout>
