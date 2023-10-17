<script setup>



import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    paginatorObj: Object
})


</script>

<template>
    <div class="w-full bg-gray-50 p-3 flex justify-between ">

        <span>Showing {{props.paginatorObj.from}} to {{props.paginatorObj.to}} of {{props.paginatorObj.total}} results</span>

        <div class="flex text-lg rounded-lg overflow-hidden border">


            <div v-for="link in props.paginatorObj.links" class="flex justify-center items-center border p-1.5" :class="{'bg-blue-900' : link.active}" >
                <NavLink :href="link.url"  :class="{'text-white' : link.active}">
                    <span v-html="link.label"></span>
                </NavLink>
            </div>


        </div>

    </div>
</template>

<style scoped>

</style>
