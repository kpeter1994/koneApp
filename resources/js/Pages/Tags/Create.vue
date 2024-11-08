<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import {computed, watch, ref, onMounted} from 'vue';
import {onClickOutside,} from "@vueuse/core";
import Editor from '@tinymce/tinymce-vue'
import NativeLink from "@/Components/NativeLink.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import TextInput from "@/Components/form/TextInput.vue";
import {formater} from "@/utils.js";
import ImageUploadComponent from "@/Components/image/ImageUploadComponent.vue";


const props = defineProps({
    errors: Object,
});


const form = useForm({
        name: 'Új tag',
        slug: '',

    }
)

const formattedUrl = computed(() => formater.formatURL(form.name));

watch(() => form.name, (newTitle) => {
    form.slug = formater.formatURL(newTitle);
});

const save = () => {
    form.post(route('tag.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
}





</script>

<template>
    <Head title="Hírfolyam"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i
                class="fa-solid fa-book-open opacity-75 mr-1.5"></i>Tag létrehozás</h2>
        </template>


        <div class="py-6 px-3">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-bold mb-3">{{ form.title }}</h1>
            </div>
            <div class="max-w-7xl mx-auto flex justify-between gap-6">


                <div class="p-6 rounded-2xl bg-slate-100 max-w-2xl shadow-2xl w-1/3">
                    <div class="mb-3">
                        <InputLabel class="mt-3">Tag</InputLabel>
                        <TextInput class="w-full" v-model="form.name"/>
                        <p class="text-red-500" v-if="props.errors.name">{{props.errors.name}}</p>
                    </div>
                    <div class="mb-3">
                        <InputLabel class="mt-3">URL</InputLabel>
                        <TextInput class="w-full" v-model="form.slug"/>
                        <p class="text-red-500" v-if="props.errors.slug">{{props.errors.slug}}</p>
                    </div>



                    <button @click="save"
                                class="inline-flex items-center px-4 py-2 bg-green-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-green-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-green-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                    >
                        <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                        Létrehozás
                    </button>



                </div>

            </div>


        </div>


    </AuthenticatedLayout>
</template>
