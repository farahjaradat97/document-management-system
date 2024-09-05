<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import HeaderLayout from "./HeaderLayout.vue";
import SideBarItems from "@/Components/SideBarItems.vue";
defineProps({
    title: String,
});
</script>

<template>
    <div>
        <Head :title="title" />
        <div class="border">
            <HeaderLayout />
        </div>
        <div class="flex min-h-screen">
            <SideBarItems />
            <main class="flex-1 bg-light-gray">
                <div class="px-8 py-6">
                    <div class="flex justify-between gap-3 items-start flex-col sm:flex-row sm:items-center">
                        <p class="text-3xl font-bold">
                            {{ title }}
                        </p>
                        <slot name="action" />
                    </div>
                </div>
                <slot name="content" />
            </main>
        </div>
    </div>
</template>
