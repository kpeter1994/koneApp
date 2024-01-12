<script setup>
import { defineProps, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TableComponent from "@/Components/tables/TableComponent.vue";
import OrderForm from "@/Components/partials/OrderForm.vue";
import {onClickOutside} from '@vueuse/core'

const props = defineProps({
    workers: Object,
    orders: Object,
    ordersWeek: Object,
});

const formVisited = ref(false)
const selectedWorker = ref(null);

const handleClicked = (worker) => {
    selectedWorker.value = worker;
}

const target = ref(null)

const close = () => formVisited.value = false


onClickOutside(target, close)


</script>

<template>
    <Head title="Karbantartók" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Karbantartók</h2>
        </template>

        <Transition name="slide-up" appear>
            <div class="py-6">
            <div class=" max-w-[1400px] mx-auto sm:px-6 lg:px-8 ">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-gray-900 font-semibold mb-3">Karbantartók elérhetősége</h2>

                    <div class="relative overflow-x-auto  sm:rounded-lg">
                        <TableComponent
                            @updateFormVisited="formVisited = $event"
                            @sendWorker="handleClicked($event)"
                            :workers="workers"
                            :orders="orders"
                        ></TableComponent>
                    </div>
                </div>
            </div>
        </div>
        </Transition>

        <div  v-if="formVisited" class="top-0 fixed bg bg-gray-800 bg-opacity-25 w-full min-h-screen flex justify-center items-center backdrop-blur-sm z-30">
            <OrderForm ref="target" :orders="props.ordersWeek" :worker="selectedWorker" ></OrderForm>
        </div>


    </AuthenticatedLayout>
</template>

