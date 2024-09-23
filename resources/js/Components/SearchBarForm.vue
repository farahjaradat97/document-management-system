<script setup>
import TextInput from "./TextInput.vue";
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

//Variables
const search = ref("");
let params = new URLSearchParams(window.location.search);

//Functions
const handelSearch = async () => {
    //Set the search varaible to parameters
    params.set("search", search.value);
    router.get(window.location.pathname + "?" + params.toString());
    search.value = params.get("search");
    if (search.value == "") {
        //remove search params for router
        router.get(window.location.pathname);
    }
    
};
onMounted(() => {
    // Initialize the search value on component mount
    search.value = params.get("search");
});
</script>

<template>
    <div class="flex justify-end">
        <div class="relative">
            <TextInput
                type="text"
                placeholder="Search"
                class="h-[35px]"
                v-model="search"
                @keyup.enter.prevent="handelSearch()"
            />
            <span
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"
            >
                <i class="mdi mdi-magnify"></i>
            </span>
        </div>
    </div>
</template>
