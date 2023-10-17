<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import ErrorForm from "@/Components/partials/ErrorForm.vue";
import {formatDate, formatTime} from "@/utils.js";
import InputLabel from "@/Components/form/InputLabel.vue";
import TextInput from "@/Components/form/TextInput.vue";


const props = defineProps({
    error: Object
});

const form = useForm({
    equipment_id: props.error.id,
    description: '',
    error_type: 'normal',
    troubleshooter: props.error.worker,
    isStand: 'igen',
    injured: '',
    whistleblower: '',
    whistleblower_tel: '',
    comment: '',
})
console.log(props.error)

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-yellow-500 text-xl  dark:text-gray-200 leading-tight"><i class="fa-solid fa-toolbox mr-1.5"></i>Hibabejenetések</h2>
        </template>

        <div class="py-6 ">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="relative overflow-x-auto  sm:rounded-lg mx-auto">
                        <div class="bg-white p-6 rounded-2xl max-w-4xl mx-auto">
                            <form class="flex flex-col gap-3" @submit.prevent="form.post(route('error.store'))">
                                <div v-if="props.error.comment" class="p-3 bg-blue-100 rounded-2xl">
                                    <p class="text-blue-950">
                                        <i class="fa-solid fa-circle-info mr-1.5"></i>
                                        {{ props.error.comment}}
                                    </p>
                                </div>
                                <span class="font-semibold text-gray-900"><span class="text-gray-500">partner neve: </span>{{ props.error.name}}</span>
                                <span class="font-semibold text-gray-900"><span class="text-gray-500">belépési cím: </span>{{ props.error.address}}</span>
                                <div class="flex gap-3">
                                    <span class="font-semibold text-gray-900"><span class="text-gray-500">karbantartó: </span>{{ props.error.worker}}</span>
                                    <span class="text-red-500"><i class="fa-solid fa-circle-exclamation mr-1.5"></i>Nem elérhető</span>

                                    <span class="font-semibold text-gray-900"><span class="text-gray-500">ügyeletes(ek): </span>
                        <span class="py-1.5 px-3 bg-green-100 rounded-2xl shadow">
                            {{ props.error.worker}} 3
                        </span>
                        <span class="py-1.5 px-3 bg-green-100 rounded-2xl shadow">
                            {{ props.error.worker}} 5
                        </span>

                    </span>
                                </div>

                                <div class="flex flex-col gap-3">
                                    <div>
                                        <input-label value="Hiba elhárító karbantartó"></input-label>
                                        <text-input v-model="form.troubleshooter"></text-input>
                                    </div>
                                    <div class="w-full">
                                        <input-label value="Hiba leírása"></input-label>
                                        <textarea v-model="form.description" class="border-gray-300 w-full dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div>
                                        <input-label value="Hiba típusa"></input-label>
                                        <input type="radio" id="normal" name="error_type" class="mr-1.5" checked value="normal">
                                        <label for="normal">normal</label><br>
                                        <input type="radio" id="beragadas" name="error_type" class="mr-1.5" value="beragadas">
                                        <label for="beragadas">beragadás</label><br>
                                    </div>
                                    <div>
                                        <input-label value="Áll-e a lift?"></input-label>
                                        <input type="radio" id="igen" name="stand" checked class="mr-1.5" value="igen">
                                        <label for="igen">igen</label><br>
                                        <input type="radio" id="nem" name="stand" class="mr-1.5" value="nem">
                                        <label for="nem">nem</label><br>
                                    </div>
                                    <div>
                                        <input-label  value="Hány sérült van?"></input-label>
                                        <text-input v-model="form.injured"></text-input>
                                    </div>
                                    <div>
                                        <input-label value="Bejelentő neve"></input-label>
                                        <text-input v-model="form.whistleblower" ></text-input>
                                    </div>
                                    <div>
                                        <input-label value="Bejelentő telefonszáma"></input-label>
                                        <text-input v-model="form.whistleblower_tel" ></text-input>
                                    </div>
                                </div>

                                <div class="w-full">
                                    <input-label value="Megjegyzés"></input-label>
                                    <textarea v-model="form.comment" class="border-gray-300 w-full dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    ></textarea>
                                </div>

                                <div class="flex justify-end">
                                    <button
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                        type="submit"
                                    >Rögzít</button>
                                </div>


                            </form>
                        </div>

                    </div>

                </div>
        </div>


    </AuthenticatedLayout>
</template>
