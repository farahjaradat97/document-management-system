<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";
import CreateOrUpdateProjectForm from "@/Components/Projects/CreateOrUpdateProjectForm.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    projects: Object,
    orgId: Number,
});

const openCTeateProjectModal = ref(false);
const projectToEdit = ref(null);
const form = useForm({
    name: "",
    org_id: props.orgId,
});
// Function to open the model tocreate or update the project
const openCreateProjectModal = ref(false);

const openCreateProjectModalFun = (project) => {
    openCreateProjectModal.value = true;
    projectToEdit.value = project;
    form.name = project?.name;
};

// Function to create new project or update exists project
const createProject = () => {
    if (projectToEdit.value) {
        form.patch(route("projects.update"), {
            project: projectToEdit.value.id,
        });
    } else {
        form.post(route("projects.create"), {
            onSuccess: () => {
                openCreateProjectModal.value = false;
                form.reset();
            },
            onFinish: () => form.reset(),
        });
    }
};
const closeModalAndResetFrom = () => {
    openCreateProjectModal.value = false;

    // The reset method resets the form fields to their initial state, while the clearErrors method clears any validation errors if present.
    form.reset();
    form.clearErrors();
};
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
            <div v-if="projects.data.length" class="w-full">
                <table class="table">
                    <thead>
                        <tr>
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
                            <td>
                                <i
                                    class="mdi mdi-pencil cursor-pointer"
                                    @click.stop
                                ></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </AuthenticatedLayout>

    <Modal
        max-width="md"
        :show="openCreateProjectModal"
        @close="closeModalAndResetFrom"
        :title="projectToEdit ? 'Update Project' : 'Create Project'"
    >
        <form @submit.prevent="createProject">
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
                        required
                        :message="form.errors.name"
                        autofocus
                    />
                </div>
            </div>
            <div class="border-t border-light-gray-200 min-h-[55px] mt-3">
                <div class="p-4 py-3">
                    <PrimaryButton type="submit"> Save</PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
