<script setup>
import {ref} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";


const { flash } = usePage().props;
const flashMessage = ref(flash.success);


const form = useForm({
    excel_file: null
})

const handleFileUpload = (event) => {
    form.excel_file = event.target.files[0];
    console.log(form.excel_file);
};

const submit = () => {
   form.post(route('import'))
}


</script>

<template>
    <form @submit.prevent="submit" class="flex justify-center items-center gap-1.5">
        <label class="block text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap" for="excel_file"></label>
        <input class="block w-full  text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="excel_file" name="excel_file" type="file" @change="handleFileUpload" />

        <button class="flex justify-center items-center gap-1.5 px-2 py-1 bg-blue-100 rounded font-semibold" type="submit"><i class="fa-solid fa-file-excel"></i> Importálás</button>
    </form>
<!--    <div v-if="flashMessage">-->
<!--        {{ flashMessage }}-->
<!--    </div>-->
</template>

<style scoped>

</style>
