<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";
import Toaster from "@/Components/Toaster.vue";
import CreateOrUpdateProjectForm from "@/Components/Projects/CreateOrUpdateProjectForm.vue";
import InputLabel from "@/Components/InputLabel.vue";
import NoDataFound from "@/Components/NoDataFound.vue";
import SearchBarForm from "@/Components/SearchBarForm.vue";
const props = defineProps({
    projects: Object,
    orgId: Number,
});
// Varaibles
let params = new URLSearchParams(window.location.search);
const search = ref(params.get("search"));
const projectToEdit = ref(null);
const openCreateProjectModal = ref(false);
const showToaster = ref(false);
const toasterMessage = ref("");

//Functions

// Function to open the model tocreate or update the project
const openCreateProjectModalFun = (project) => {
    openCreateProjectModal.value = true;
    projectToEdit.value = project;
};

//handle modal
const handelToasterMessage = (event) => {
    showToaster.value = true;
    toasterMessage.value = event;
    // The reset method resets the form fields to their initial state, while the clearErrors method clears any validation errors if present.
};

//Navigate To project folders and files page
const goToproject = (project) => {
    router.visit(route("projects.folder", project.id));
};
</script>
<template>
    <Head title="Projects" />
    <AuthenticatedLayout title="Projects">
        <template #action>
            <PrimaryButton @click="openCreateProjectModalFun(null)"
                >New project</PrimaryButton
            >
        </template>
        <template #content>
            <Toaster
                :message="toasterMessage"
                v-if="showToaster"
                type="success"
            >
            </Toaster>
            <div class="w-full">
                <table v-if="projects.data.length || search">
                    <thead>
                        <tr rowspan="12" class="justify-end bg-white">
                            <th colspan="12" class="font-medium">
                                <SearchBarForm />
                            </th>
                        </tr>
                        <tr v-if="projects.data.length || !search">
                            <th>Name</th>
                            <th>Last Modified</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="project in projects.data"
                            @click="goToproject(project)"
                            :key="project.id"
                        >
                            <td>
                                {{ project.name }}
                            </td>
                            <td>
                                {{ project.updated_at }}
                            </td>
                            <td
                                class="text-primary flex justify-center font-semibold text-sm"
                            >
                                <div
                                    class="flex items-center gap-1"
                                    @click.stop="
                                        openCreateProjectModalFun(project)
                                    "
                                >
                                    <i
                                        class="mdi mdi-square-edit-outline cursor-pointer text-primary"
                                    ></i>
                                    <span
                                        class="hover:underline cursor-pointer"
                                    >
                                        Edit
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tr
                        v-if="!projects.data.length && search"
                        rowspan="12"
                        class="justify-end bg-white"
                    >
                        <th colspan="12" class="font-medium">
                            <NoDataFound message="No results found " />
                        </th>
                    </tr>
                </table>
                <div v-else>
                    <NoDataFound
                        class="border border-light-gray-200"
                        message="No projects have been created yet."
                    />
                </div>
            </div>
        </template>
    </AuthenticatedLayout>

    <Modal
        @close="openCreateProjectModal = false"
        max-width="md"
        :show="openCreateProjectModal"
        :title="projectToEdit ? 'Update Project' : 'Create Project'"
    >
        <CreateOrUpdateProjectForm
            @showToaster="handelToasterMessage"
            :orgId="orgId"
            @close="openCreateProjectModal = false"
            :project="projectToEdit"
        />
    </Modal>
</template>
<style></style>
