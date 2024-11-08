<script setup>
// Import Vue FilePond
import vueFilePond from 'vue-filepond';
import {ref} from "vue";

// Import FilePond styles
import 'filepond/dist/filepond.min.css';

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Import image preview plugin styles
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

const emit = defineEmits(['image-uploaded'])

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);

const myFiles = ref([]);



const handleFilePondInit = () => {
    console.log('FilePond has initialized');
};

const handleProcessFile = (error, file) => {
    if (error) {
        console.error('Hiba történt a fájl feldolgozása közben', error);
        return;
    }
    // Feldolgozzuk a választ, hogy kinyerjük az elérési utat
    try {
        const response = JSON.parse(file.serverId);
        const imagePath = response.location;
         console.log('Feltöltött fájl elérési útja:', imagePath);

        emit('image-uploaded', imagePath)
    } catch (e) {
        console.error('Hiba történt a válasz feldolgozása közben', e);
    }
};

</script>

<template>

    <file-pond
        name="file"
        ref="pond"
        label-idle="Húzd ide a képeket vagy <span class='filepond--label-action'>Böngéssz</span>"
        allow-multiple="true"
        accepted-file-types="image/jpeg, image/png, image/gif, image/webp"
        server="/api/upload"
        v-bind:files="myFiles"
        v-on:init="handleFilePondInit"
        v-on:processfile="handleProcessFile"
    />

</template>

<style scoped>

</style>
