<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { usePage, router } from "@inertiajs/vue3";
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

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
    <header
        class="bg-white flex justify-between border-light-gray-200 h-[65px] p-2 border-b w-screen px-4"
    >
        <div class="flex items-center justify-start p-4 h-[64px]">
            <Link :href="route('projects')">
                <ApplicationLogo class="block h-10 w-auto" />
            </Link>
        </div>
        <div class="relative flex justify-end">
            <Dropdown align="right" width="40">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button
                            type="button"
                            class="flex items-center justify-center h-12 w-12 rounded-full bg-dark-gray-900 text-white font-bold mr-2"
                        >
                            <div
                                class="flex items-center justify-center h-8 w-8 rounded-full text-lg text-white font-bold"
                            >
                                {{ userNameLetters }}
                            </div>
                        </button>
                    </span>
                </template>
                <template #content>
                    <DropdownLink
                        :href="route('profile.edit')"
                        class="text-primary"
                    >
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
    </header>
    <slot> </slot>
</template>
