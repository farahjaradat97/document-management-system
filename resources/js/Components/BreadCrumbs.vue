<template>
    <nav class="text-sm" aria-label="Breadcrumb">
        <ol class="list-reset flex items-center mb-2">
            <li v-for="(crumb, index) in crumbs" :key="index">
                <div class="flex items-center " v-if="index !== crumbs.length - 1">
                    <Link :href="crumb.url" class="text-primary hover:text-light-primary">{{ crumb.name }}</Link>
                    <i class="mdi mdi-chevron-right"> </i>

                </div>
                <div class="flex items-center " v-else>
                    {{ crumb.name }}
                </div>

            </li>
        </ol>
    </nav>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    crumbs: {
        type: Array,
        required: true,
    },
});
</script>
