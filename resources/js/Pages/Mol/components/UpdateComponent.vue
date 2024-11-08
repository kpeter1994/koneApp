<script setup>
import { ref } from 'vue';

const fileInput = ref(null);

const handleDragOver = (event) => {
    // Itt kezeld az eseményt, amikor a fájl a doboz fölé kerül
};

const handleDrop = (event) => {
    // Amikor a fájl beleesik a dobozba
    const files = event.dataTransfer.files;
    processFiles(files);
};

const handleFileSelect = (event) => {
    // Amikor a felhasználó fájlokat választ ki a fájlválasztóval
    const files = event.target.files;
    processFiles(files);
};

const triggerFileInput = () => {
    // Ez aktiválja a rejtett fájl inputot, amikor a dobozra kattintanak
    fileInput.value.click();
};

const processFiles = (files) => {
    if (files.length > 0) {
        // Itt kezeld a kiválasztott fájlt/fájlokat
        // Például kinyerheted az adatokat, vagy elkészítheted a csatolmányok listáját
        console.log(files[0]); // Ezt a részt módosíthatod, hogy illeszkedjen a saját logikádhoz
    }
};
</script>

<template>
    <div class="drop-area" @dragover.prevent="handleDragOver" @drop.prevent="handleDrop">
        Húzz ide egy Excel fájlt vagy kattints a feltöltéshez.
        <input type="file" @change="handleFileSelect" ref="fileInput" style="display: none" accept=".xlsx, .xls"/>
    </div>
</template>

<style scoped>
.drop-area {
    border: 2px dashed #ccc;
    padding: 20px;
    cursor: pointer;
}
</style>
