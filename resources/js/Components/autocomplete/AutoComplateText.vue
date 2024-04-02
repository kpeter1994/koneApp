<script setup>
import {ref, computed, defineEmits, watch} from 'vue';
import InputLabel from "@/Components/form/InputLabel.vue";
import axios from "axios";


const emit = defineEmits(['update:modelValue']);
const userInput = ref('');
const suggestions = ref([]);
const tabUsed = ref(false);

const autoComplate = () => {
    axios.post(route('getDescription', {search: userInput.value}))
        .then(response => {
            suggestions.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error("Hiba történt az adatok lekérésekor:", error);
        });
}

watch(userInput, (value) => {
    if (!tabUsed.value) {
        autoComplate(value);
    }
})

// Az input mező eseménykezelője, frissíti a modelValue-t
function onInput(event) {
    userInput.value = event.target.value;
    emit('update:modelValue', userInput.value); // Frissíti a szülő komponens állapotát
    tabUsed.value = false;
}

// Tab billentyűvel az első javaslat kiválasztása
function onTab() {
    if (suggestions.value.length > 0) {
        userInput.value = suggestions.value[0];
        emit('update:modelValue', userInput.value);
        tabUsed.value = true;
        suggestions.value = [];
    }
}
</script>

<template>
    <InputLabel>Bejelentő</InputLabel>
    <div class="relative flex items-center">
        <textarea class="w-full p-2 w-full rounded"
                  :value="userInput"
                  @input="onInput"
                  @keydown.tab.prevent="onTab">

        </textarea>

        <span v-if="suggestions.length > 0 && userInput.length > 2" class="absolute top-0 bg-white p-2 opacity-30 pointer-events-none">
            {{ suggestions[0] }}
        </span>
    </div>
</template>

<style>
/* Stílusok a javaslatok megjelenítéséhez */
</style>
