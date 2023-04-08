<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from "@inertiajs/vue3"
import {Inertia} from "@inertiajs/inertia";

export default {
    components: {
        AppLayout, Head, Link
    },
    props: {
        users: Array,
    },
    setup() {
        const destroy = (id) => {
            if (confirm('¿Desea Eliminar?')) {
                Inertia.delete(route('users.destroy', id))
            }
        }
        return { destroy }
    },
    methods: {
        updateStatus(user) {
            const status = user.status ? 0 : 1;
            axios.get('/changeStatus', {
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
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuarios lista 
            </h2>
        </template>
        <table class="mt-4 min-w-full divide-y divide-gray-200 border">
            <thead>
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
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <tr v-for="user in users" :key="user.id">
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{ user.id}}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{ user.name}}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{ user.email}}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{ user.status}}
                </td>
                <td>
                    <label class="relative inline-flex items-center mr-5 cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" :checked="user.status" @change="updateStatus(user)" :data-id="user.id">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Activo</span>
                    </label>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    <Link :href="route('users.show', user.id)" class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">Ver</Link>
                    <Link :href="route('users.edit', user.id)" class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">Editar</Link>
                    <button  @click="destroy(user.id)" type="button" class="px-2 py-1 bg-red-600 text-white rounded font-bold uppercase">
                        Eliminar
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </AppLayout>
</template>

