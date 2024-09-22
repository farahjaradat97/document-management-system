
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


    
    
         <div v-for="item in SideBarItem" :key="item.name"> 
             <NavLink
                 :href="item.href"
                 :active="item.active"
             >
                
                 {{ item.name }}
             </NavLink>
         </div>
     
        
</template>
