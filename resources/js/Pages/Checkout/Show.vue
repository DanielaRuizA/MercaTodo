<script>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
    props: ['status'],
    components: {
        Link,
        AppLayout,
    }
}
</script>
<template>
    <AppLayout title="Status Orden">
        <div v-if="status === 'COMPLETED'">
            <div class="flex items-center justify-center">
                <img width="200"
                    src="https://static.vecteezy.com/system/resources/previews/017/177/933/original/round-check-mark-symbol-with-transparent-background-free-png.png"
                    alt="Pago Exitoso">
            </div>
            <div class="flex items-center justify-center">
                <h1>Pago Exitoso !</h1>
            </div>
            <div class="flex items-center justify-center">
                <h4>Su pago fue procesado Exitosamente con PlaceToPay</h4>
            </div>
        </div>
        <div v-else-if="status === 'PENDING'">
            <div class="flex items-center justify-center">
                <img width="200" src="https://cdn-icons-png.flaticon.com/512/3756/3756719.png" alt="Pago Pendiente">
            </div>
            <div class="flex items-center justify-center">
                <h1>Pago está Pendiente !</h1>
            </div>
            <div class="flex items-center justify-center">
                <h4>Su pago está pendiente con PlaceToPay</h4>
            </div>
        </div>
        <div v-else="status === 'CANCELED'">
            <div class="flex items-center justify-center">
                <img width="200"
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/OOjs_UI_icon_cancel-destructive.svg/1200px-OOjs_UI_icon_cancel-destructive.svg.png"
                    alt="Pago Cancelado">
            </div>

            <div class="flex items-center justify-center">
                <h1>Pago Cancelado !</h1>
            </div>

            <div class="flex items-center justify-center">
                <h4>Su pago fue cancelado con PlaceToPay</h4>
            </div>
        </div>
        <div class="my-4 flex items-center justify-center">
            <Link :href="route('orders.index')" class="underline hover:text-indigo-700 transition"> Mis Ordenes
            </Link>
        </div>
    </AppLayout>
</template>
