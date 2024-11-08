<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import ToastComponent from "@/Components/notification/ToastComponent.vue";
import { ref } from 'vue';




const props = defineProps({
    flash: Object,
});



const message = ref('');

const form = useForm({
    call_count: '',
    comment: ''
})

const createReport = () => {
    form.post(route('call-center-report.store'))
}




</script>

<template>
    <Head title="Főügyelet" />

    <AuthenticatedLayout>

        <template #toast>
            <ToastComponent :flash="message"></ToastComponent>
        </template>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-bus opacity-75 mr-1.5"></i>
                Főügyelet</h2>
        </template>

        <Transition name="slide-up" appear>
            <div class="py-6 px-3 max-w-2xl mx-auto">
                <div class="flex gap-6">

                    <form @submit.prevent="createReport()" class="w-full bg-white p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Napi Call Center jelentés</h3>

                        <div class="mt-6">
                            <label for="">Hívás szám</label>
                            <input v-model="form.call_count" class="w-full rounded" type="number">
                        </div>

                        <div class="mt-6">
                            <label for="">Megjegyzés</label>
                            <input v-model="form.comment" class="w-full rounded" type="text">
                        </div>

                        <Button type="submit" class="p-3 mt-6 bg-blue-500 text-white rounded hover:bg-blue-400">Rögzítés</Button>
                    </form>

                </div>

            </div>
        </Transition>

    </AuthenticatedLayout>
</template>

<style>

</style>
