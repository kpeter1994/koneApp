<script setup>
import {ref, computed, defineEmits, watch} from 'vue';
import InputLabel from "@/Components/form/InputLabel.vue";
import axios from "axios";


const emit = defineEmits(['update:modelValue']);
const userInput = ref('');
const suggestions = ref([]);

const autoComplate = (value) => {
    axios.post(route('getWhistleblower', {search: value}))
        .then(response => {
            suggestions.value = response.data;
            console.log(response.data[0]);
        })
        .catch(error => {
            console.error("Hiba történt az adatok lekérésekor:", error);
        });
}

watch(userInput, (value) => {
    autoComplate(value)
})




// Az input mező eseménykezelője, frissíti a modelValue-t
function onInput(event) {
    userInput.value = event.target.value;
    emit('update:modelValue', userInput.value); // Frissíti a szülő komponens állapotát
}

// Tab billentyűvel az első javaslat kiválasztása
function onTab() {
    if (suggestions.value.length > 0) {
        userInput.value = suggestions.value[0];
        emit('update:modelValue', userInput.value); // Frissíti a szülő komponens állapotát
    }
}
</script>

<template>
    <InputLabel>Bejelentő</InputLabel>
    <div class="relative flex items-center">
        <input class="w-full p-2 w-full rounded"
               type="text"
               :value="userInput"
               @input="onInput"
               @keydown.tab.prevent="onTab"
        >
        <ul v-if="suggestions.length > 0 && userInput.length > 2" class="absolute z-10 bg-white p-2 opacity-30">
            <li>{{ suggestions[0] }}</li>
        </ul>
    </div>
</template>

<style>
/* Stílusok a javaslatok megjelenítéséhez */
</style>
