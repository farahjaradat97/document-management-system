<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    organization:Object

})
</script>
<template >
    <Link

    :href="route('organizations.users',organization.id)"
    >
        <div class="bg-white border borderl-light-gray-200 rounded-lg shadow-md p-4">
            <p class="font-bold text-lg text-gray-800 mb-2">
                {{ organization.name }}
        </p>
        <p class="text-sm light-gray-500">
                <span class="font-medium text-gray-800">Total Users:</span> {{ organization.users_count }}
            </p>
            <p class="text-sm light-gray-500">
                <span class="font-medium text-gray-800">Last Modified:</span> {{ new Date(organization.updated_at).toLocaleDateString() }}
            </p>
            </div>
        </Link>
</template>