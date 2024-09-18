<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    project:Object

})
</script>
<template >
    <Link

    :href="route('organizations.users',organization.id)"
    >
        <div class="bg-white border borderl-light-gray-200 rounded-lg shadow-md p-4">
            <p class="font-bold text-lg text-gray-800 mb-2">
                {{ project.name }}
        </p>
            </div>
        </Link>
</template>