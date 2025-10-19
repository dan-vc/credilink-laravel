<x-app-layout>
    <div class="bg-white rounded-xl px-4 py-3 mb-3 flex gap-2 justify-between items-stretch">
        <x-search-input placeholder="Buscar..." id="search-input" />

        <div class="flex gap-2">
            <x-secondary-button href="{{ route('dashboard') }}">
                Gestionar Roles
            </x-secondary-button>

            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-new-user')">
                Añadir Empleado
            </x-primary-button>
        </div>

        <x-modal name="create-new-user" focusable>
            <form method="post" action="" class="p-6">
                @csrf
                <h2 class="text-xl font-semibold mb-4">
                    Añadir Nuevo Empleado
                </h2>

                <!-- Nombre -->
                <div class="mb-4">
                    <x-input-label for="name" value="Nombre" class="mb-1" />
                    <x-text-input id="name" class="block w-full" type="text" name="name" required
                        autocomplete="name" placeholder="Carlos Ramirez" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Correo Electrónico -->
                <div class="mb-4">
                    <x-input-label for="email" value="Correo Electrónico" class="mb-1" />
                    <x-text-input id="email" class="block w-full" type="email" email="email" required
                        autocomplete="email" placeholder="carlosrv@gmail.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <x-input-label for="password" value="Contraseña" class="mb-1" />
                    <div class="flex gap-2">
                        <x-text-input id="password" class="block w-full" type="password" name="password" required
                            autocomplete="password" placeholder="**********" />

                        <button class="inline-flex items-center bg-gray-200 rounded-md px-4">
                            Generar
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
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

                <!-- Rol -->
                <div class="mb-4">
                    <x-input-label for="role_id" value="Rol" class="mb-1" />
                    <x-select-input id="role_id" class="block w-full" name="role_id" required autocomplete="role_id">
                        <option value="">Seleccione un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                </div>

                <x-primary-button class="w-full">
                    Generar Crédito
                </x-primary-button>
            </form>
        </x-modal>
    </div>

    <div class="bg-white rounded-xl px-4 py-8">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
            Empleados
        </h2>

        <div class="relative overflow-x-auto flex">
            <table class="w-full min-w-max text-sm text-left text-gray-800 font-medium">
                <thead class="text-gray-400 fontP-medium border-b border-gray-200">
                    <tr>
                        <th scope="col" class="p-3 font-medium">ID</th>
                        <th scope="col" class="p-3 font-medium">Nombre</th>
                        <th scope="col" class="p-3 font-medium">Correo Electrónico</th>
                        <th scope="col" class="p-3 font-medium">Rol</th>
                        <th scope="col" class="p-3 font-medium">Fecha de Creación</th>
                        <th scope="col" class="p-3 font-medium">Fecha de Actualización</th>
                        <th scope="col" class="p-3 font-medium">Estado</th>
                        <th scope="col" class="p-3 font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="bg-white border-b border-gray-200 filter-item">
                            <td class="px-3 py-4">
                                {{ $user->id }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $user->name }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $user->email }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $user->role->name }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $user->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-3 py-4">
                                {{ $user->updated_at->format('Y-m-d') }}
                            </td>
                            <td class="px-3 py-4">
                                @switch($user->status)
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
