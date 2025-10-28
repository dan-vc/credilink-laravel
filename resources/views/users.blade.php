<x-app-layout>
    <div class="bg-white rounded-xl px-4 py-3 mb-3 flex flex-col gap-2 justify-between items-stretch sm:flex-row md:flex-col lg:flex-row">
        <form action="" method="get" class="contents">
            <x-search-input placeholder="Buscar..." id="search-input" />
        </form>

        <div class="flex flex-col sm:flex-row gap-2">
            <x-secondary-button href="{{ route('roles') }}">
                <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.3 20L6.9 16.8C6.68333 16.7167 6.47933 16.6167 6.288 16.5C6.09667 16.3833 5.909 16.2583 5.725 16.125L2.75 17.375L0 12.625L2.575 10.675C2.55833 10.5583 2.55 10.446 2.55 10.338V9.663C2.55 9.55433 2.55833 9.44167 2.575 9.325L0 7.375L2.75 2.625L5.725 3.875C5.90833 3.74167 6.1 3.61667 6.3 3.5C6.5 3.38333 6.7 3.28333 6.9 3.2L7.3 0H12.8L13.2 3.2C13.4167 3.28333 13.621 3.38333 13.813 3.5C14.005 3.61667 14.1923 3.74167 14.375 3.875L17.35 2.625L20.1 7.375L17.525 9.325C17.5417 9.44167 17.55 9.55433 17.55 9.663V10.337C17.55 10.4457 17.5333 10.5583 17.5 10.675L20.075 12.625L17.325 17.375L14.375 16.125C14.1917 16.2583 14 16.3833 13.8 16.5C13.6 16.6167 13.4 16.7167 13.2 16.8L12.8 20H7.3ZM9.05 18H11.025L11.375 15.35C11.8917 15.2167 12.371 15.021 12.813 14.763C13.255 14.505 13.659 14.1923 14.025 13.825L16.5 14.85L17.475 13.15L15.325 11.525C15.4083 11.2917 15.4667 11.046 15.5 10.788C15.5333 10.53 15.55 10.2673 15.55 10C15.55 9.73267 15.5333 9.47033 15.5 9.213C15.4667 8.95567 15.4083 8.70967 15.325 8.475L17.475 6.85L16.5 5.15L14.025 6.2C13.6583 5.81667 13.2543 5.496 12.813 5.238C12.3717 4.98 11.8923 4.784 11.375 4.65L11.05 2H9.075L8.725 4.65C8.20833 4.78333 7.72933 4.97933 7.288 5.238C6.84667 5.49667 6.44233 5.809 6.075 6.175L3.6 5.15L2.625 6.85L4.775 8.45C4.69167 8.7 4.63333 8.95 4.6 9.2C4.56667 9.45 4.55 9.71667 4.55 10C4.55 10.2667 4.56667 10.525 4.6 10.775C4.63333 11.025 4.69167 11.275 4.775 11.525L2.625 13.15L3.6 14.85L6.075 13.8C6.44167 14.1833 6.846 14.5043 7.288 14.763C7.73 15.0217 8.209 15.2173 8.725 15.35L9.05 18ZM10.1 13.5C11.0667 13.5 11.8917 13.1583 12.575 12.475C13.2583 11.7917 13.6 10.9667 13.6 10C13.6 9.03333 13.2583 8.20833 12.575 7.525C11.8917 6.84167 11.0667 6.5 10.1 6.5C9.11667 6.5 8.28733 6.84167 7.612 7.525C6.93667 8.20833 6.59933 9.03333 6.6 10C6.60067 10.9667 6.93833 11.7917 7.613 12.475C8.28767 13.1583 9.11667 13.5 10.1 13.5Z"
                        fill="white" />
                </svg>
                Gestionar Roles
            </x-secondary-button>

            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-new-user')">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 10H10V16H6V10H0V6H6V0H10V6H16V10Z" fill="white" />
                </svg>
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
                    <x-text-input id="email" class="block w-full" type="email" name="email" required
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

        {{ $users->links() }}

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
                    <x-text-input id="password" class="block w-full" type="password" name="password"
                        autocomplete="password" placeholder="**********" />
                    <p class="text-xs text-gray-500 mt-1">
                        Deja este campo vacío si no deseas cambiar la contraseña.
                    </p>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
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

                <!-- Rol -->
                <div class="mb-4">
                    <x-input-label for="role_id" value="Rol" class="mb-1" />
                    <x-select-input id="role_id" class="block w-full" name="role_id" required
                        autocomplete="role_id" x-bind:value="selected?.role.id">
                        <option value="">Seleccione un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                </div>

                <x-primary-button class="w-full">
                    Actualizar Empleado
                </x-primary-button>
            </form>
        </x-modal>

        <x-modal name="confirm-delete-user" focusable>
            <form method="post" action="" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-xl font-semibold mb-2">
                    ¿Estás seguro de que deseas eliminar el empleado <span class="font-bold italic"
                        x-text="selected?.name"></span>?
                </h2>

                <p class="text-gray-600 mb-4">
                    Esta acción es irrevesible.
                </p>

                <x-text-input type="hidden" name="id" required x-bind:value="selected?.id" />

                <x-danger-button class="w-full">
                    Eliminar Empleado
                </x-danger-button>
            </form>
        </x-modal>
    </div>
</x-app-layout>
