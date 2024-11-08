<script setup>
import AutoComplete from 'primevue/autocomplete';
import {ref} from "vue";
import axios from "axios";
import InputLabel from "@/Components/form/InputLabel.vue";

const props = defineProps({
    route: String
})

const emit = defineEmits(['update:modelValue']);

const userInput = ref('');
const suggestions = ref([]);


function search(event) {
    axios.post(route(props.route, {search: event.query}))
        .then(response => {
            suggestions.value = response.data;
        })
        .catch(error => {
            console.error("Hiba történt az adatok lekérésekor:", error);
        });
        emit('update:modelValue', event.query); // Frissíti a szülő komponens állapotát
}

</script>

<template>
    <div>
        <InputLabel>Bejelentő</InputLabel>
        <AutoComplete class="rounded-1" v-model="userInput" :suggestions="suggestions" @complete="search" />

    </div>
</template>

<style scoped>

</style>
