<script setup>
import axios from "axios";
import {ref, watch} from 'vue';
import InputLabel from "@/Components/form/InputLabel.vue";

const errorList = ref([]);
const search = ref('');


watch(search, (newValue, oldValue) => {
    if (newValue.length > 3) {
        axios.post('/api/search-mol-error',{error_code: search.value})
            .then(response => {
                errorList.value = response.data;
                console.log(response.data);
            })
            .catch(error => {
                console.log(error);
            });
    }

})


</script>

<template>
    <div class="p-6 bg-white rounded-2xl shadow w-full">
        <InputLabel label="Keresés" class="">Hibakód</InputLabel>
        <input v-model="search" type="text" class="w-full border-gray-300 rounded-md">
        <div class="bg-slate-100 mt-4 p-3 rounded-2xl">
        <table>
            <tr>
                <th class="px-2 py-1">Hiba kód</th>
                <th class="px-2 py-1">Hiba neve</th>
                <th class="px-2 py-1">Hiba típusa</th>
                <th class="px-2 py-1">Hiba leírása</th>
                <th class="px-2 py-1">Súlyosság</th>
                <th class="px-2 py-1">Súlyosság</th>
                <th class="px-2 py-1">Lehetséges megoldás</th>
            </tr>
            <tr v-for="error in errorList">
                <td class="px-2 py-1">{{error.code}}</td>
                <td class="px-2 py-1">{{error.name}}</td>
                <td class="px-2 py-1">{{error.message}}</td>
                <td class="px-2 py-1">{{error.description}}</td>
                <td class="px-2 py-1">{{error.seriousness1}}</td>
                <td class="px-2 py-1">{{error.seriousness2}}</td>
                <td class="px-2 py-1">{{error.optional_solution	}}</td>

            </tr>
        </table>

    </div>
    </div>
</template>

<style scoped>

</style>
