<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import HeaderLayout from "./HeaderLayout.vue";
import SideBarItems from "@/Components/SideBarItems.vue";
import BreadCrumbs from "@/Components/BreadCrumbs.vue";
defineProps({
    title: String,
    breadCrumbs:Array,
    sideBar:{
        type:Boolean,
        default:true,
        required:false
    }
});

</script>

<template>
    <Head :title="title" />
    <HeaderLayout />
        <div class="flex min-h-screen  bg-light-gray  ">
          
            <main class="mx-auto bg-light-gray  h-full w-full px-8 py-6  md:px-6 lg:px-8 ">

                <div class="pb-6" >
                    <div class="flex justify-between gap-3 items-start flex-col sm:flex-row sm:items-center">
                        <p class="text-3xl font-bold w-full">
                            {{ title }}
                            <BreadCrumbs class='mt-3':crumbs="breadCrumbs" />
                        </p>
                        <slot name="action" />
                    </div>
                </div>
                <slot name="content" />
            </main>
        </div>
</template>
