<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { computed, ref, onMounted } from "vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Toaster from "@/Components/Toaster.vue";
import {  router, Head, Link } from "@inertiajs/vue3";
import SearchBarForm from "@/Components/SearchBarForm.vue";
import NoDataFound from "@/Components/NoDataFound.vue";
import CreateOrUpdateFolder from "@/Components/Projects/CreateOrUpdateFolder.vue";
const props = defineProps({
    files: Object,
    folders: Object,
    projectId: String,
    ancestors: Object,
    projectName: String,
    api_token: String,
});

// Varaibles
let params = new URLSearchParams(window.location.search);
const search = ref(params.get("search"));
const openCreateFolderModal = ref(false);
const folderToEdit = ref(null);
const showToaster = ref(false);
const toasterMessage = ref("");
const crumbs = computed(() => {
    const allProject = [
        {
            name: "Projects",
            path: route("projects"),
        },
    ];
    return [...allProject, ...props.ancestors.data];
});



//Functions

// Function to open the model tocreate or update the project
const openCreateFolderModalFun = (folder) => {
    openCreateFolderModal.value = true;
    folderToEdit.value = folder;
};
const handelToasterMessage = (event) => {
    showToaster.value = true;
    toasterMessage.value = event;
    // The reset method resets the form fields to their initial state, while the clearErrors method clears any validation errors if present.
};
 //Navigate To folder page 
const openFolder = (file) => {
    if (!file.is_folder) {
        return;
    } else {
        const url = route("projects.folder", {
            id: props.projectId,
            folders: encodeURIComponent(file.path),
        });
        router.visit(url);
    }
};
</script>
<template>
    <Head :title="projectName" />

    <AuthenticatedLayout :title="projectName" :bread-crumbs="crumbs">
        <template #action>
            <div class="flex justify-end gap-2">
                <PrimaryButton @click="openCreateFolderModalFun(null)">
                    Create Folder</PrimaryButton
                >
                <Link
                    :href="
                        folders.data.parent_id
                            ? route('projects.showUploadForm', {
                                  id: projectId,
                                  folders: encodeURIComponent(
                                      folders.data.path
                                  ),
                              })
                            : route('projects.showUploadFormForRoot', {
                                  id: projectId,
                              })
                    "
                >
                    <PrimaryButton> Upload File</PrimaryButton>
                </Link>
            </div>
        </template>
        <template #content>
            <Toaster
                :message="toasterMessage"
                v-if="showToaster"
                type="success"
            >
            </Toaster>
            <div class="w-full">
                <table v-if="files?.data?.length || search">
                    <thead>
                        <tr rowspan="12" class="justify-end bg-white">
                            <th colspan="12" class="font-medium">
                                <SearchBarForm />
                            </th>
                        </tr>
                        <tr v-if="files.data.length || !search">
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Refrence Number</th>
                            <th>Date</th>
                            <th v-if="search">Location</th>
                            <th>Size</th>
                            <th>Last Modified</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            @dblclick="openFolder(file)"
                            v-for="file of files?.data"
                            :key="file.id"
                        >
                            <td>
                                <div
                                    class="flex items-center gap-2 justify-start"
                                >
                                    <i
                                        v-if="file.is_folder"
                                        class="mdi mdi-folder text-primary text-4xl"
                                    >
                                    </i>
                                    <i
                                        v-else
                                        class="mdi mdi-file-pdf-box text-error text-4xl"
                                    >
                                    </i>
                                    <p
                                        class="text-lg capitalize	 font-semiBold text-dark-gray-900"
                                    >
                                        {{ file.name}}
                                    </p>
                                </div>
                            </td>
                            <td>
                                {{ file.subject ?? "-" }}
                            </td>
                            <td>
                                {{ file.refrence_number ?? "-" }}
                            </td>
                            <td>
                                {{ file.date ?? "-" }}
                            </td>
                            <td v-if="search">
                                {{ file.parent_name }}
                            </td>
                            <td>
                                {{ file.size ?? "-" }}
                            </td>
                            <td>
                                {{ file.updated_at ?? "-" }}
                            </td>
                            <td
                            >
                                <div
                                v-if="file.is_folder"

                                    class="flex items-center gap-1 text-primary flex justify-center font-semibold text-sm"
                                    @click.stop="openCreateFolderModalFun(file)"
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
                        v-if="!files?.data.length && search"
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
                        message="No Folders or Files have been created yet."
                    />
                </div>
            </div>
        </template>
    </AuthenticatedLayout>

    <Modal
    :title="folderToEdit ? 'Update Folder' : 'Create Folder'"

        max-width="md"
        :show="openCreateFolderModal"
        @close="openCreateFolderModal = false"
    >
        <CreateOrUpdateFolder
        @showToaster="handelToasterMessage"

            :project-id="projectId"
            @close="openCreateFolderModal = false"
            :folder="folderToEdit"
            :parent-folder="folders.data"
        />
    </Modal>
</template>
