<script setup>
import { ref } from "vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import HeaderLayout from "@/Layouts/HeaderLayout.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import OrganizationsCard from "@/Components/Admin/OrganizationsCard.vue";

defineProps({
    organizations: {
        type: [
            {
                name: String,
                createdAt: String,
                updatedAt: String,
            },
        ],
    },
});
const form = useForm({
    name: "",
});
const openCreateOrgModal = ref(false);
const nameInput = ref(null);

const addOrganization = () => {
    form.post(route("organizations.create"), {
        onSuccess: () => {
            openCreateOrgModal.value = false;
            form.reset();
        },
        onFinish: () => form.reset(),
    });
};
const closeModalAndResetFrom = () => {
    openCreateOrgModal.value = false;

    // The reset method resets the form fields to their initial state, while the clearErrors method clears any validation errors if present.
    form.reset();
    form.clearErrors();
};
</script>

<template>
    <Head title="Organizations" />
    <AuthenticatedLayout title="Organizations">
        <template #action>
            <PrimaryButton
                @click="
                    openCreateOrgModal = true;
                    form.reset();
                "
                >Add Oranization</PrimaryButton
            >
        </template>
        <template #content>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <OrganizationsCard
                    v-for="organization in organizations"
                    :key="organization.id"
                    :organization="organization"
                />
            </div>
        </template>
    </AuthenticatedLayout>

    <Modal
        max-width="md"
        :show="openCreateOrgModal"
        @close="closeModalAndResetFrom"
        title="Add Organization"
    >
        <form @submit.prevent="addOrganization">
            <div class="p-4">
                <div>
                    <InputLabel
                        for="name"
                        value="name"
                        :error="form.errors.name"
                    />
                    <TextInput
                        id="name"
                        type="text"
                        class="w-full"
                        v-model="form.name"
                        :message="form.errors.name"
                        ref="nameInput"
                        required
                        autocomplete="name"
                    />
                </div>
            </div>
            <div class="border-t border-light-gray-200 min-h-[55px] mt-3">
                <div class="flex justify-start gap-2 p-4 py-3">
                    <PrimaryButton type="submit"> Save</PrimaryButton>
                    <PrimaryButton
                        @click="closeModalAndResetFrom"
                        outlined
                        type="button"
                    >
                        Cancel</PrimaryButton
                    >
                </div>
            </div>
        </form>
    </Modal>
</template>
