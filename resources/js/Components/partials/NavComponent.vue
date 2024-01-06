<script setup>

import {Link} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
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
<!--            <NavLink v-if="$page.props.auth.user.status === 100" :href="route('register')" :active="route().current('register')">-->
<!--                <i class="fa-solid fa-user opacity-75 mr-1.5"></i>-->
<!--                Regisztráció-->
<!--            </NavLink>-->
            <!--                              <NavLink :href="route('report')" :active="route().current('report')">-->
            <!--                                  <i class="fa-solid fa-chart-bar opacity-75 mr-1.5"></i>-->
            <!--                                  Statisztikák-->
            <!--                              </NavLink>-->

        </div>
    </div>
</template>

<style scoped>

</style>
