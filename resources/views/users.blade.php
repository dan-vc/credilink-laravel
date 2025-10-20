<x-app-layout>
    <div class="bg-white rounded-xl px-4 py-3 mb-3 flex gap-2 justify-between items-stretch">
        <x-search-input placeholder="Buscar..." id="search-input" />

        <div class="flex gap-2">
            <x-secondary-button href="{{ route('roles') }}">
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
                    Añadir Empleado
                </x-primary-button>
            </form>
        </x-modal>
    </div>

    <div class="bg-white rounded-xl px-4 py-8" x-data="{ selected: null }">
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
                            <td class="px-3 py-4">
                                <span x-data
                                    x-on:click="$dispatch('open-modal', 'edit-user'); selected = @js($user)"
                                    class="inline-flex border-2 border-orange-300 rounded-md bg-orange-50 px-2 py-1.5 cursor-pointer transition">
                                    <svg width="20" height="20" viewBox="0 0 17 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.1172 10.1836L11.9922 9.30859C12.1289 9.17188 12.375 9.28125 12.375 9.47266V13.4375C12.375 14.1758 11.7734 14.75 11.0625 14.75H1.4375C0.699219 14.75 0.125 14.1758 0.125 13.4375V3.8125C0.125 3.10156 0.699219 2.5 1.4375 2.5H8.90234C9.09375 2.5 9.20312 2.74609 9.06641 2.88281L8.19141 3.75781C8.13672 3.8125 8.08203 3.8125 8.02734 3.8125H1.4375V13.4375H11.0625V10.3477C11.0625 10.293 11.0625 10.2383 11.1172 10.1836ZM15.3828 4.6875L8.21875 11.8516L5.73047 12.125C5.01953 12.207 4.41797 11.6055 4.5 10.8945L4.77344 8.40625L11.9375 1.24219C12.5664 0.613281 13.5781 0.613281 14.207 1.24219L15.3828 2.41797C16.0117 3.04688 16.0117 4.05859 15.3828 4.6875ZM12.7031 5.50781L11.1172 3.92188L6.03125 9.00781L5.8125 10.8125L7.61719 10.5938L12.7031 5.50781ZM14.4531 3.34766L13.2773 2.17188C13.168 2.03516 12.9766 2.03516 12.8672 2.17188L12.0469 2.99219L13.6328 4.60547L14.4805 3.75781C14.5898 3.62109 14.5898 3.45703 14.4531 3.34766Z"
                                            fill="#FFB400" />
                                    </svg>
                                </span>

                                <span x-data
                                    x-on:click="$dispatch('open-modal', 'confirm-delete-user'); selected = @js($user)"
                                    class="inline-flex border-2 border-red-300 rounded-md bg-red-50 px-2 py-1.5 cursor-pointer transition">
                                    <svg width="20" height="20" viewBox="0 0 14 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.20312 12.125C8.01172 12.125 7.875 11.9883 7.875 11.7969V5.89062C7.875 5.72656 8.01172 5.5625 8.20312 5.5625H8.85938C9.02344 5.5625 9.1875 5.72656 9.1875 5.89062V11.7969C9.1875 11.9883 9.02344 12.125 8.85938 12.125H8.20312ZM12.6875 2.9375C12.9062 2.9375 13.125 3.15625 13.125 3.375V3.8125C13.125 4.05859 12.9062 4.25 12.6875 4.25H12.25V13.4375C12.25 14.1758 11.6484 14.75 10.9375 14.75H3.0625C2.32422 14.75 1.75 14.1758 1.75 13.4375V4.25H1.3125C1.06641 4.25 0.875 4.05859 0.875 3.8125V3.375C0.875 3.15625 1.06641 2.9375 1.3125 2.9375H3.55469L4.48438 1.40625C4.70312 1.02344 5.14062 0.75 5.60547 0.75H8.36719C8.83203 0.75 9.26953 1.02344 9.48828 1.40625L10.418 2.9375H12.6875ZM5.55078 2.14453L5.08594 2.9375H8.88672L8.42188 2.14453C8.39453 2.11719 8.33984 2.0625 8.28516 2.0625H5.71484C5.6875 2.0625 5.6875 2.0625 5.6875 2.0625C5.63281 2.0625 5.57812 2.11719 5.55078 2.14453ZM10.9375 13.4375V4.25H3.0625V13.4375H10.9375ZM5.14062 12.125C4.94922 12.125 4.8125 11.9883 4.8125 11.7969V5.89062C4.8125 5.72656 4.94922 5.5625 5.14062 5.5625H5.79688C5.96094 5.5625 6.125 5.72656 6.125 5.89062V11.7969C6.125 11.9883 5.96094 12.125 5.79688 12.125H5.14062Z"
                                            fill="#EB4034" />
                                    </svg>
                                </span>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-modal name="edit-user" focusable>
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
                        autocomplete="name" placeholder="Carlos Ramirez" x-bind:value="selected?.name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Correo Electrónico -->
                <div class="mb-4">
                    <x-input-label for="email" value="Correo Electrónico" class="mb-1" />
                    <x-text-input id="email" class="block w-full" type="email" name="email" required
                        autocomplete="email" placeholder="carlosrv@gmail.com" x-bind:value="selected?.email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <x-input-label for="password" value="Contraseña" class="mb-1" />
                    <x-text-input id="password" class="block w-full" type="password" name="password" required
                        autocomplete="password" placeholder="**********" x-bind:value="selected?.password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Estado -->
                <div class="mb-4">
                    <x-input-label for="status" value="Estado" class="mb-1" />
                    <x-select-input id="status" class="block w-full" name="status" required
                        autocomplete="status" x-bind:value="selected?.status" >
                        <option value="">Seleccione un estado</option>
                        <option value="active">Activado</option>
                        <option value="inactive">Desactivado</option>
                    </x-select-input>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <!-- Rol -->
                <div class="mb-4">
                    <x-input-label for="role_id" value="Rol" class="mb-1" />
                    <x-select-input id="role_id" class="block w-full" name="role_id" required
                        autocomplete="role_id" x-bind:value="selected?.role.id" >
                        <option value="">Seleccione un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                </div>

                <x-primary-button class="w-full">
                    Actualizar Usuario
                </x-primary-button>
            </form>
        </x-modal>

        <x-modal name="confirm-delete-user" focusable>
            <form method="post" action="" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-xl font-semibold mb-2">
                    ¿Estás seguro de que deseas eliminar el usuario <span class="font-bold italic"
                        x-text="selected?.name"></span>?
                </h2>

                <p class="text-gray-600 mb-4">
                    Esta acción es irrevesible.
                </p>

                <x-text-input type="hidden" name="id" required x-bind:value="selected?.id" />

                <x-danger-button class="w-full">
                    Eliminar Usuario
                </x-danger-button>
            </form>
        </x-modal>
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
