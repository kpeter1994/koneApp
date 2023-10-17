<script setup>

import InputLabel from "@/Components/form/InputLabel.vue";
import InputError from "@/Components/form/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    worker: Object,
    errors: Object,
});



const form = useForm({
    worker_id: props.worker.id,
    status: 'Délelötti ügyeletes',
    start_status: '2023-01-01',
    end_status: '2023-01-02',
})
console.log(form)

</script>

<template>
        <div class="bg-white p-6 rounded-2xl max-w-4xl">
            <form class="flex flex-col gap-3" @submit.prevent="form.post(route('order.store'))">
                <span class="font-semibold">{{ worker.name }}</span>
                <div class="flex gap-3">
                    <div>
                        <InputLabel value="Státusz"></InputLabel>
                        <select
                            v-model="form.status"
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        >
                            <option value="Délelötti ügyeletes">Délelötti ügyeletes</option>
                            <option value="Délutáni ügyeletes">Délutáni ügyeletes</option>
                            <option value="Mozgólépcső ügyeletes">Mozgólépcső ügyeletes</option>
                            <option value="Szabadságon">Szabadságon</option>
                            <option value="Külön munka">Külön munka</option>
                        </select>

                        <input-error></input-error>
                    </div>
                    <div>
                        <InputLabel value="Státusz kezdete"></InputLabel>
                        <input
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            type="datetime-local"
                            v-model="form.start_status"
                        >
                        <input-error></input-error>
                    </div>
                    <div>
                        <InputLabel value="Státusz vége"></InputLabel>
                        <input
                            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            type="datetime-local"
                            v-model="form.end_status"
                        >
                        <input-error></input-error>
                    </div>

                </div>
                <div class="flex justify-end">
                    <button
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                        :disabled="form.processing"
                        type="submit"
                    >Rögzít</button>
                </div>


            </form>
        </div>
</template>

<style scoped>

</style>
