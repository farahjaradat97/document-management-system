<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { computed, ref, onMounted } from "vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm, router, Head, Link } from "@inertiajs/vue3";
import Cookies from 'js-cookie';

const props = defineProps({
    files: Object,
    folders: Object,
    projectId: String,
    ancestors: Object,
    projectName: String,
});
const crumbs = computed(() => {
    const allProject = [
        {
            name: "Projects",
            path: route("projects"),
        },
    ];
    return [...allProject, ...props.ancestors.data];
});
const form = useForm({
    name: "",
    parent: null,
});

const openCreateFolderModal = ref(false);
const createFolder = () => {
    form.parent = props.folders.data.id;

    form.post(route("projects.createFolder", props.projectId), {
        onSuccess: () => {
            openCreateFolderModal.value = false;
            form.reset();
        },
        onFinish: () => form.reset(),
    });
};
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
const magicSearch = ref(false)
const search = ref('')
let params = new URLSearchParams(window.location.search)
const cookie =ref()
const handelSearch = async () => {
    if (!magicSearch.value) {

        params.set('search', search.value)
        router.get(window.location.pathname + '?' + params.toString())
        search.value = params.get('search');
    } else {
       const response =await  axios.post('http://127.0.0.1:8000/search' ,{search:search.value},{
        headers: {
          'Authorization': `Bearer ${ Cookies.get('api_token')}`
        }

       })
       console.log(response);


    }

}
onMounted(() => {
    search.value = params.get('search')
})
</script>
<template>
   
    <Head :title="projectName" />
    <AuthenticatedLayout :title="projectName" :bread-crumbs="crumbs">
        <template #action>
            <div class="flex justify-end gap-2">
                <PrimaryButton @click="openCreateFolderModal = true">
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
            <div class="relative w-full items-center gap-2">
                <TextInput
                    type="text"
                    class="block w-full mb-3"
                    :class="
                        magicSearch
                            ? 'placeholder:text-primary border-primary'
                            : 'placeholder:text-gray-400 border-gray-300'
                    "
                    v-model="search"
                    @keyup.enter.prevent="handelSearch()"
                    :placeholder="
                        magicSearch
                            ? 'Search with AI'
                            : 'Search for files and folders'
                    "
                />
                <button
                    type="button"
                    @click="magicSearch = !magicSearch"
                    class="absolute inset-y-0 right-0 flex items-center pr-3"
                >
                    <i
                        :class="
                            magicSearch
                                ? 'mdi mdi-magic-staff text-primary'
                                : ' mdi mdi-magic-staff text-gray'
                        "
                    >
                    </i>
                </button>
            </div>

            <div v-if="files?.data?.length" class="w-full">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Refrence Number</th>
                            <th>Date</th>
                            <th v-if="search">Location</th>
                            <th>Size</th>
                            <th>Last Modified</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="border-b transition duration-300 ease-in-out hover:bg-blue-100 cursor-pointer"
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
                                        class="text-lg font-semiBold text-dark-gray-900"
                                    >
                                        {{ file.name }}
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

    <Modal
        title=" Create Folder"
        max-width="md"
        :show="openCreateFolderModal"
        @close="openCreateFolderModal = false"
    >
        <form @submit.prevent="createFolder">
            <div class="p-4">
                <div>
                    <InputLabel for="name" value="name" />

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
