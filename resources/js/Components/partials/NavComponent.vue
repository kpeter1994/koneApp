<script setup>

import {Link} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import MolLogo from "@/Components/image/MolLogo.vue";
</script>

<template>
    <div class="flex">
        <!-- Logo -->
        <div class="shrink-0 flex items-center">
            <Link :href="route('dashboard')">
                <ApplicationLogo
                    class="block h-9 w-auto fill-current rounded text-gray-800 dark:text-gray-200"
                />
            </Link>
        </div>
        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <NavLink v-if="$page.props.auth.user.status === 1 || $page.props.auth.user.status > 2" class="relative" :href="route('dashboard')" :active="route().current('dashboard')">
                <i class="fa-solid fa-rss opacity-75 mr-1.5"></i>
                Hírfolyam
            </NavLink>
            <NavLink v-if="$page.props.auth.user.status === 1 || $page.props.auth.user.status > 2" :href="route('equipment.index')" :active="route().current('equipment.index')">
                <i class="fa-solid fa-elevator opacity-75 mr-1.5"></i>
                Berendezések
            </NavLink>
            <NavLink v-if="$page.props.auth.user.status === 1 || $page.props.auth.user.status > 2" :href="route('error.index')" :active="route().current('error.index')">
                <i class="fa-solid fa-toolbox opacity-75 mr-1.5"></i>
                Hibabejenetések
            </NavLink>
            <NavLink v-if="$page.props.auth.user.status === 1 || $page.props.auth.user.status > 2" :href="route('workers.index')" :active="route().current('workers.index')">
                <i class="fa-solid fa-user-gear opacity-75 mr-1.5"></i>
                Karbantartók
            </NavLink>
            <NavLink v-if="$page.props.auth.user.status > 1" :href="route('posts.index')" :active="route().current('posts.index')">
                <i class="fa-solid fa-book-open opacity-75 mr-1.5"></i>
                Tudástár
            </NavLink>
            <NavLink v-if="$page.props.auth.user.status > 1" :href="route('mol.index')" :active="route().current('mol.index')">
                <MolLogo class="opacity-50 mr-1.5 w-6" />
                MOL
            </NavLink>
            <NavLink v-if="$page.props.auth.user.status > 2" :href="route('fougyelet.index')" :active="route().current('fougyelet.index')">
                <i class="fa-solid fa-bus opacity-75 mr-1.5"></i>
                Főügyelet
            </NavLink>
            <NavLink v-if="$page.props.auth.user.status > 1" :href="route('call-center-report.index')" :active="route().current('call-center-report.index')">
                <i class="fa-solid fa-phone-volume opacity-75 mr-1.5"></i>
                Call Center
            </NavLink>

        </div>
    </div>
</template>

<style scoped>

</style>
