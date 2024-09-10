
<script setup>
import ApplicationLogo from "./ApplicationLogo.vue";
import NavLink from "./NavLink.vue";
import { Link, router } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
const showSidebar = ref(true);

const SideBarItem = ref([
    {
        name: "Projects",
        href: "/projects",
        icon: "mdi-view-grid-outline",
        active : route().current('projects*'),

    },
    {
        name: "Organizations",
        href: "/organizations",
        icon: "mdi-domain",
        active : route().current('organizations*') ,
        
    },
  
]);

</script>

<template>

<nav
   class=" bg-light-gray text-dark-gray-900 h-full transition-all duration-300 ease-in-out w-[320px]"
          
        >
        
           
            <ul class="flex-1 space-y-2 px-4 py-6">
                <li v-for="item in SideBarItem" :key="item.name"> 
                    <NavLink
                        :href="item.href"
                        :active="item.active"
                        class="flex block items-center rounded w-full"
                    >
                        <i :class="[
                            `mdi ${item.icon} mr-4`,
                            item.active ? 'text-white' : 'text-dark-gray-900'
                        ]"></i> 
                        {{ item.name }}
                    </NavLink>
                </li>
            </ul>
            
        </nav>    
</template>
