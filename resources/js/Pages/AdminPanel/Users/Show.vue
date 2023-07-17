<script>
import AppLayout from '@/Layouts/AppLayoutUser.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout, Link
    },
    props: {
        user: Object,
    },
    setup() {
        const destroy = (id) => {
            Swal.fire({
                title: '¿Desea Eliminar?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value) {
                    Inertia.delete(route('users.destroy', id)).then(() => {
                        Swal.fire(
                            'Eliminado',
                            'El producto ha sido eliminado exitosamente',
                            'success'
                        );
                    });
                }
            });
        }
        return { destroy };
    },
    computed: {
        status() {
            if (this.user.status === 'Active') {
                return 'Usuario Esta habilitado'
            } else {
                return 'Usuario Esta Deshabilitado'
            }
        }
    },
    methods: {
        updateStatus(user) {
            const status = (user.status === 'Active') ? 'Inactive' : 'Active';
            axios.get('/change/user/status', {
                params: { status: status, user_id: user.id }
            }).then(response => {
                console.log(response.data.success);
                user.status = !user.status;
            }).catch(error => {
                console.error(error);
            });
        }
    }
}
</script>

<template>
    <AppLayout title="Detalles del Usuario">
        <nav id="store" class="w-full z-30 top-0 px-6 py-1">
            <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl ">
                    Detalles Del Usuario {{ user.name }}
                </a>
            </div>
        </nav>
        <table class="mt-4 min-w-full divide-y divide-gray-200 border">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nombre</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Cambiar
                            Status</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Editar</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Eliminar</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ user.id }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ user.name }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ user.email }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ status }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        <label class="relative inline-flex items-center mr-5 cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" :checked="user.status === 'Inactive'"
                                @change="updateStatus(user)" :data-id="user.id">
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                            </div>
                        </label>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        <Link :href="route('users.edit', user.id)"
                            class="px-2 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded font-bold uppercase mr-2">
                        Editar</Link>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        <button @click="destroy(user.id)" type="button"
                            class="px-2 py-1 bg-red-600  hover:bg-red-500 text-white rounded font-bold uppercase">
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
            <Link :href="route('users.index')"
                class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-md">
            Volver
            </Link>
        </div>
    </AppLayout>
</template>


