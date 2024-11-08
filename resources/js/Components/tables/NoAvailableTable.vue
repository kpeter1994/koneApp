<script setup>
import {formater} from "@/utils.js";
import {onMounted, ref} from "vue";
import axios from "axios";

const notAvailable = ref([]);

const props = defineProps({
    day: Number
});


onMounted(() => {
    axios.get(route('notAvailable'))
        .then((response) => {
            notAvailable.value = response.data;
            console.log(response.data);
            return notAvailable;
        })
        .catch((error) => {
            console.log(error);
        });
})


console.log('napok:'+ (props.day));

</script>

<template>
    <table class="rounded-2xl overflow-hidden bg-slate-50 shadow w-full">
        <tr>
            <td class="bg-blue-700 text-white rounded text-center" colspan="3">{{formater.getToday(props.day)}}</td>
        </tr>

        <tr>
            <th class="p-1.5 bg-red-100">Szabadságon</th>
        </tr>

        <tr class="bg-red-100" v-for="notAvailableWorker in notAvailable" >
            <td
                v-if="notAvailableWorker.status === 'Szabadságon'
                && formater.isFirstDateBiggerOrEqual(notAvailableWorker.end_status.split(' ')[0], formater.getToday2(props.day))
                && formater.isFirstDateBiggerOrEqual(formater.getToday2(props.day), notAvailableWorker.start_status.split(' ')[0])"
                class="p-1.5">{{notAvailableWorker.worker.name}}</td>
        </tr>

        <tr>
            <th colspan="2" class="p-3 bg-orange-100">Külön munka</th>
        </tr>

        <tr class="bg-orange-100" v-for="notAvailableWorker in notAvailable">
            <td v-if="notAvailableWorker.status === 'Külön munka'
            && formater.isFirstDateBiggerOrEqual(notAvailableWorker.end_status.split(' ')[0], formater.getToday2(props.day))
                && formater.isFirstDateBiggerOrEqual(formater.getToday2(props.day), notAvailableWorker.start_status.split(' ')[0])"
                class="p-3">{{notAvailableWorker.worker.name }}</td>
        </tr>

    </table>
</template>

<style scoped>

</style>
