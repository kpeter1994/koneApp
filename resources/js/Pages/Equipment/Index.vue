<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import {ref, watch} from "vue";
import ErrorForm from "@/Components/partials/ErrorForm.vue";
import {onClickOutside} from "@vueuse/core";


const props = defineProps({
    equipments: Object
});


const search = ref(props.search)
const form = useForm({})
const formVisited = ref(false)
const target = ref(null)
const selectedEquipment = ref(null);

console.log(props.equipments)

const handleClicked = (equipment) => {
    formVisited.value = true;
    selectedEquipment.value = equipment;
}

const close = () => formVisited.value = false


onClickOutside(target, close)

watch(search, value => {

    form.get(route('equipment.index', {search: value}) , {
        preserveState: true,
        replace: true
    })
})

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i class="fa-solid fa-elevator mr-1.5"></i>Berendezések</h2>
        </template>

        <div class="py-6">
            <div class=" mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div>
                        <div class="flex justify-end gap-6 items-center mb-3">
                            <button class="w-8 h-8 flex justify-center items-center bg-green-100 rounded text-blue-900">
                                <i class="fa-solid fa-file-excel"></i>
                            </button>
                            <div class="relative flex items-center">
                                <i class="fa-solid fa-magnifying-glass absolute ml-3 pointer-events-none z-30"></i>
                                <input
                                    class="rounded-lg pl-8"
                                    type="text"
                                    v-model="search">
                            </div>
                        </div>
                    </div>

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Szerzödésszám
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Partner neve
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Beépítési cím
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Equipment
                            </th>
                            <th scope="col" class="px-6 py-3">
                                ÉMI szám
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Berendezés típusa
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Karbantartó
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Supervizor
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Rated load
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Inventory number
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Megjegyzés
                            </th>
                            <th scope="col" class="px-6 py-3">

                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="equipment in props.equipments" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ equipment.contract_ref }}
                            </th>
                            <td class="px-6 py-4">
                                {{ equipment.name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ equipment.address }}
                            </td>
                            <td class="px-6 py-4">
                                {{ equipment.type }}
                            </td>
                            <td class="px-6 py-4">
                                {{ equipment.equipment }}
                            </td>
                            <td class="px-6 py-4">
                                {{ equipment.emi }}
                            </td>
                            <td class="px-6 py-4">
                                {{ equipment.worker }}
                            </td>
                            <td class="px-6 py-4">
                                {{ equipment.supervisor }}
                            </td>
                            <td class="px-6 py-4">
                                {{ equipment.rated_load }}
                            </td>
                            <td class="px-6 py-4">
                                {{ equipment.comment }}
                            </td>
                            <td class="px-6 py-4">
                                {{ equipment.inventory_number }}
                            </td>
                            <td class="px-6 py-4 text-right">
                               <button
                                   @click="handleClicked(equipment)"
                                   class="font-medium text-yellow-500 dark:text-blue-500 hover:underline flex items-center whitespace-nowrap">
                                   <i class="fa-solid fa-wrench mr-1.5 opacity-75"></i>
                                   Hiba bejelentés
                               </button>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

       <div  v-if="formVisited" class="fixed top-0 bg-gray-800 bg-opacity-25 w-full h-screen flex justify-center items-center backdrop-blur-sm z-30">
            <ErrorForm :selectedEquipment="selectedEquipment" ref="target"></ErrorForm>
       </div>

    </AuthenticatedLayout>
</template>
