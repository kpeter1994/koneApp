<script setup>
import { ref, watch, defineEmits, computed } from 'vue';
import {useForm} from "@inertiajs/vue3";
import PaginatorCpomponent from "@/Components/tables/PaginatorCpomponent.vue";
import OrderForm from "@/Components/partials/OrderForm.vue";

const props = defineProps({
    workers: Object,
    orders: Object,
    search: String
});

const emit = defineEmits(['updateFormVisited', 'sendWorker']);


const search = ref(props.search)

const form = useForm({})

const handleClicked = (worker) => {
    emit('updateFormVisited', true);
    emit('sendWorker', worker);
}

watch(search, value => {

    /*form al müködik*/
    form.get(route('workers.index', {search: value}) , {
        preserveState: true,
        replace: true
    })
})

const orderClass = (worker_id, orders) => {
    const order = orders.find(o => o.worker_id === worker_id);

    if (order && worker_id === order.worker_id) {

        if(order.status === 'Délelötti ügyeletes') {
            return 'bg-green-100 hover:bg-green-200 text-gray-700'
        }

        if (order.status === 'Délutáni ügyeletes') {
            return 'bg-green-100 hover:bg-green-200 text-gray-700'
        }

        if (order.status === 'Mozgólépcső ügyeletes') {
            return 'bg-blue-100 hover:bg-blue-200 text-gray-700'
        }

        if (order.status === 'Mozgólépcső ügyeletes') {
            return 'bg-blue-100 hover:bg-blue-200 text-gray-700'
        }

        if (order.status === 'Szabadságon') {
            return 'bg-red-100 hover:bg-red-200 text-gray-700 text-opacity-75'
        }

        if (order.status === 'Külön munka') {
            return 'bg-yellow-100 hover:bg-yellow-200 text-gray-700 text-opacity-75'
        }
    } else {
        return 'bg-white text-gray-900 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-600'
    }
}

const orderRank = (worker_id, orders) => {
    const order = orders.find(o => o.worker_id === worker_id);

    if (order && worker_id === order.worker_id) {

        if(order.status === 'Délelötti ügyeletes') {
            return 1
        }

        if (order.status === 'Délutáni ügyeletes') {
            return 2
        }

        if (order.status === 'Mozgólépcső ügyeletes') {
            return 3
        }

        if (order.status === 'Külön munka') {
            return 5
        }
        if (order.status === 'Szabadságon') {
            return 6
        }
    } else {
        return 7
    }
}



const sortedWorkers = computed(() => {
    return [...props.workers].sort((a, b) => {
        const rankA = orderRank(a.id, props.orders);
        const rankB = orderRank(b.id, props.orders);

        return rankA - rankB; // Az értékek alapján rendezzük a munkásokat
    });
});




</script>

<template>
    <div class="flex justify-between items-center mb-3">
        <a class="text-blue-500 hover:text-blue-400" :href="route('order.index')">Hírfolyam<i class="fa-solid fa-chevron-right ml-1.5"></i></a>
        <div class="relative flex items-center">
            <i class="fa-solid fa-magnifying-glass absolute ml-3 pointer-events-none z-30"></i>
            <input
                class="rounded-lg pl-8"
                type="text"
                v-model="search">
        </div>
    </div>

    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                Név
            </th>
            <th scope="col" class="px-6 py-3">
                Mobil
            </th>
            <th scope="col" class="px-6 py-3">
                Beosztás
            </th>
            <th scope="col" class="px-6 py-3">
                karbantartóhoz tartozó supervizor
            </th>
            <th scope="col" class="px-6 py-3">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="worker in sortedWorkers"
            class=" border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" :class="orderClass(worker.id, props.orders)">
            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">
                <i class="fa-solid fa-phone-volume text-gray-500 opacity-75"></i>
                {{ worker.name }}
            </th>
            <td class="px-6 py-4">
                {{ worker.tel }}
            </td>
            <td class="px-6 py-4">
                {{ worker.position }}
            </td>
            <td class="px-6 py-4">
                {{ worker.supervisor }}
            </td>
            <td class="px-6 py-4 text-right">
                <button
                    @click="handleClicked(worker)"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center">
                    <i class="fa-regular fa-calendar-days mr-1.5 opacity-75"></i>
                    Beosztás
                </button>
            </td>
        </tr>

        </tbody>
    </table>

    <PaginatorCpomponent :paginator-obj="props.workers"></PaginatorCpomponent>



</template>

<style scoped>

</style>
