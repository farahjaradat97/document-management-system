<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { usePage, router } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import SideBarItems from "@/Components/SideBarItems.vue";
//to Get the first letter from user name
const userNameLetters = computed(() => {
    return (
        usePage().props.auth.user.first_name[0] +
        usePage().props.auth.user.last_name[0]
    ).toUpperCase();
});
const logout = () => {
    router.post(route("logout"));
};

</script>

<template>
    <nav class="bg-white shadow-md border-b border-light-gray-300">
        <div class="mx-auto  max-w-10xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <Link :href="route('projects')">
                        <ApplicationLogo class="block h-10 mr-4 w-auto" />
                        </Link>
                    </div>


                    <div class="ml-6 block ">
                        <div class="flex space-x-4">

                            <SideBarItems />
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

                    <div class="relative ml-3">
                        <Dropdown align="right" width="40">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="flex items-center justify-center h-12 w-12 rounded-full bg-dark-gray-900 text-white font-bold mr-2">
                                        <div
                                            class="flex items-center justify-center h-8 w-8 rounded-full text-lg text-white font-bold">
                                            {{ userNameLetters }}
                                        </div>
                                    </button>
                                </span>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('profile.edit')" class="text-primary">
                                    <div class="flex gap-3 items-center">
                                        <i class="mdi mdi-account"> </i>

                                        Profile
                                    </div>
                                </DropdownLink>

                                <form @submit.prevent="logout">
                                    <DropdownLink as="button">
                                        <div class="flex gap-3 items-center">
                                            <i class="mdi mdi-logout"> </i>

                                            Log Out
                                        </div>
                                    </DropdownLink>
                                </form>
                            </template>
                        </Dropdown>


                    </div>
                </div>
            </div>
        </div>


    </nav>

</template>
