<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ToastComponent from "@/Components/notification/ToastComponent.vue";
import TextInput from "@/Components/form/TextInput.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import { defineProps } from 'vue';


const props = defineProps({
    flash: Object,
    event: Object
});

const form = useForm({
    name: props.event.name,
    description: props.event.description,
    time: null,
    location: props.event.location,
    reporter: props.event.reporter,
    damage_value: props.event.damage_value,
});

const submitForm = () => {
    form.patch(route('updateEvent', {id: props.event.id}), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
}

</script>

<template>
    <Head title="MOL Plugge" />

    <AuthenticatedLayout>

        <template #toast>
            <ToastComponent :flash="props.flash"></ToastComponent>
        </template>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-bus opacity-75 mr-1.5"></i>
                Főügyelet</h2>
        </template>

        <Transition name="slide-up" appear>
            <div class="py-6 px-3">

                 <div class="max-w-7xl mx-auto p-6 bg-white rounded-2xl shadow text-gray-700">
                        <h1 class="text-center font-semibold">Új esemény rögzítése</h1>

                        <form @submit.prevent="submitForm" class="flex gap-6">
                            <div class="w-1/4">
                                <div class="mb-6">
                                    <InputLabel class="mt-3">Telephely</InputLabel>
                                    <select class="w-full rounded" v-model="form.location">
                                        <option>Budapest, Óradna u.5.</option>
                                        <option>Budapest, Óbuda BKV garázs</option>
                                        <option>Debrecen, Kígyóhagyma u.</option>
                                        <option>Kecskemét, Georg Knorr u.</option>
                                    </select>
                                </div>


                                <div class="mb-6">
                                    <InputLabel class="mt-3">Esemény megnevezése</InputLabel>
                                    <TextInput class="w-full" v-model="form.name" label="Teszt" placeholder="pl: LMG-000 esemény" />
                                </div>

                                <div class="mb-6">
                                    <InputLabel class="mt-3">Bejelentő</InputLabel>
                                    <TextInput class="w-full" v-model="form.reporter" label="Teszt" placeholder="" />
                                </div>

                                <div class="mb-6">
                                    <InputLabel class="mt-3">Kárérték (Ft)</InputLabel>
                                    <TextInput class="w-full" v-model="form.damage_value" label="Teszt" type="number" placeholder="pl: LMG-000 esemény" />
                                </div>

                            </div>
                            <div class="w-3/4">
                                <InputLabel class="mt-3">Esemény leírása</InputLabel>
                                <textarea class="w-full h-36 rounded" v-model="form.description" label="Teszt" placeholder="Esemény leírása" />

                                <div class="flex justify-end gap-3">
                                    <Button type="submit" class=" bg-blue-500 text-white px-3 py-1 rounded-md">Mentés</Button>
                                </div>



                            </div>

                        </form>

                    </div>

            </div>
        </Transition>

    </AuthenticatedLayout>
</template>

<style>

</style>
