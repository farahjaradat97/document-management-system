<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
defineProps({
    users: Array,
    orgId: String,
    breadcrumbs: Array,
});
</script>
<template>
    <Head title="Users" />
    <AuthenticatedLayout title="Users" :bread-crumbs="breadcrumbs">
        <template #action>
            <Link :href="route('organizations.createUsers', orgId)" as="button">
                <PrimaryButton>Invite User</PrimaryButton>
            </Link>
        </template>
        <template #content>
            <div v-if="users.length" class="w-full">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.first_name }} {{ user.last_name }}</td>
                            <td>
                                {{ user.email }}
                            </td>
                            <td>
                                {{ user.role }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-else
                class="flex flex-col items-center w-full p-2 rounded-lg"
            >
                <i class="mdi mdi-progress-close text-primary"> </i>
                <p class="font-bold text-lg text-dark-gray-900">
                    No record found
                </p>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
