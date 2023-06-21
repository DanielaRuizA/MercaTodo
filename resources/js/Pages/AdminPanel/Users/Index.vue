<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from "@inertiajs/vue3"
import { Inertia } from "@inertiajs/inertia";
import Pagination from "@/Components/Pagination.vue"

export default {
    components: {
        AppLayout, Head, Link, Pagination
    },
    props: {
        users: Object,
    },
    setup() {
        const destroy = (id) => {
            if (confirm('¿Desea Eliminar?')) {
                Inertia.delete(route('users.destroy', id))
            }
        }
        return { destroy }
    },
    data() {
        return {
            search: ''
        }
    },
    watch: {
        search: function (value) {
            this.$inertia.replace(this.route('users.index', { search: value }))
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
    <AppLayout title="Usuarios Lista">
        <nav id="store" class="w-full z-30 top-0 px-6 py-1">
            <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                    href="#">
                    lista De Usuarios Registrados
                </a>
                <div class="flex items-center" id="store-nav-content">
                    <input type="text" class="pl-3 inline-block no-underline hover:text-black" placeholder="Buscar..."
                        v-model="search">
                    <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24">
                        <path
                            d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z" />
                    </svg>
                </div>
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
                        <span
                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Inhabilitado</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ver</span>
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
                <tr v-for="user in users.data" :key="user.id">
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ user.id }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ user.name }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        {{ user.email }}
                    </td>
                    <td>
                        <label class="relative inline-flex items-center mr-5 cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" :checked="user.status === 'Inactive'"
                                @change="updateStatus(user)" :data-id="user.id">
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                            </div>
                        </label>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        <Link :href="route('users.show', user.id)"
                            class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">Ver</Link>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        <Link :href="route('users.edit', user.id)"
                            class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">Editar</Link>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                        <button @click="destroy(user.id)" type="button"
                            class="px-2 py-1 bg-red-600 text-white rounded font-bold uppercase">
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <pagination class="mt-6" :links="users.links" />
        </div>
    </AppLayout>
</template>

