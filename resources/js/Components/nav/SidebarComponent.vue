<script setup>
import {Link} from "@inertiajs/vue3";
import {ref, defineProps} from "vue";

import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavItem from "@/Components/nav/NavItem.vue";
import MolLogo from "@/Components/image/MolLogo.vue";

const props = defineProps({
    open: Boolean,
})


</script>

<template>
    <div :class="props.open ? 'relative w-[220px]' : 'absolute h-full w-[65px] hover:w-[220px]' " class=" transition-all z-10 duration-300 overflow-hidden bg-white pt-6 p-2  bg-slate-50 border-r">
        <div class="absolute top-3 left-3 flex flex-col gap-3 ">
            <div class="shrink-0 flex items-center">
                <Link class="flex items-center gap-4" :href="route('dashboard')">
                    <ApplicationLogo
                        class="block h-9 w-auto fill-current rounded text-gray-800 dark:text-gray-200"
                    />
                    Pandant
                </Link>
            </div>

            <div class="flex flex-col gap-2 mt-3">
                <NavItem :route="route('dashboard')" :active="route().current('dashboard')" name="Hírfolyam">
                    <i class="fa-solid fa-rss"></i>
                </NavItem>
                <NavItem :route="route('equipment.index')" :active="route().current('equipment.index')" name="Berendezések">
                    <i class="fa-solid fa-elevator"></i>
                </NavItem>
                <NavItem :route="route('error.index')" :active="route().current('error.index')" name="Hibabejenetések">
                    <i class="fa-solid fa-toolbox"></i>
                </NavItem>
                <NavItem :route="route('workers.index')" :active="route().current('workers.index')" name="Karbantartók">
                    <i class="fa-solid fa-user-gear"></i>
                </NavItem>
                <NavItem :route="route('posts.index')" :active="route().current('posts.index')" name="Tudástár">
                    <i class="fa-solid fa-book-open"></i>
                </NavItem>
                <NavItem :route="route('mol.index')" :active="route().current('mol.index')" name="MOL">
                    <span class="text-xs font-[700]">MOL</span>
                </NavItem>
                <NavItem :route="route('fougyelet.index')" :active="route().current('fougyelet.index')" name="Főügyelet">
                    <i class="fa-solid fa-bus"></i>
                </NavItem>
                <NavItem :route="route('call-center-report.index')" :active="route().current('call-center-report.index')" name="Call Center">
                    <i class="fa-solid fa-phone-volume"></i>
                </NavItem>



            </div>

        </div>

    </div>
</template>

<style scoped>

</style>
