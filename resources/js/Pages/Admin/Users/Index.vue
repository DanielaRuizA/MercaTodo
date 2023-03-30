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
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <tr v-for="user in users">
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

