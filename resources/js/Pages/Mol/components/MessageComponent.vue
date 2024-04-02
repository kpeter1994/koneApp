<template>
    <div class="relative flex items-center">
        <input class="w-full align-baseline p-2"
            type="text"
            v-model="userInput"
            @input="onInput"
            @keydown.tab.prevent="onTab"
        >

       <span class="absolute pointer-events-none left-2 top-2 opacity-40" v-if="filteredSuggestions.length > 0 && userInput.length > 3">{{filteredSuggestions[0]}}</span>

    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const userInput = ref('');
const suggestions = ref(['teszt elek', 'példa géza', 'próba', 'Type2-n próbáltak RFID-val töltést indítani, de nem sikerült.', 'A lift zárt ajtókkal áll']);

// Szűrt javaslatok, amelyek csak akkor jelennek meg, ha több mint 3 karakter van beírva
const filteredSuggestions = computed(() => {
    if (userInput.value.length > 2) {
        return suggestions.value.filter(suggestion =>
            suggestion.toLowerCase().includes(userInput.value.toLowerCase())
        );
    }
    return [];
});

function onInput() {
    // Az input eseménykezelője lehetőséget ad további logika implementálására
}

function onTab() {
    if (filteredSuggestions.value.length > 0) {
        userInput.value = filteredSuggestions.value[0]; // Az első javaslat kiválasztása
    }
}
</script>
<style>

</style>
