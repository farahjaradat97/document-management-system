<script setup>
import { defineEmits } from 'vue';
defineProps ({
    file:Object
})
const emit=defineEmits(['close'])

</script>

<template>
 <div class="border rounded-lg border-light-gray-300 bg-white  p-4 w-full   ">
      <div class="flex items-center  gap-4 mb-2">
        <i class="mdi mdi-close  cursor-pointer"
        @click="$emit('close')"
        >

        </i>
         <p class="font-semibold text-lg text-dark-gray-900">
            {{ file.name }}
         </p>
      </div>
      <div class="flex flex-col gap-3">
        
          <div class="flex justify-between w-full items-center gap-3">
            
            <p>
           Subject : <span>{{ file.subject }}</span>
          </p> 
            <p>
                Date : <span>{{ file.date }}</span>
            </p> 
          </div>
        <p>
            Reference Number : <span>{{ file.reference_number }}</span>
        </p> 
      </div>
<div v-if="file.related_files">

  <p class="font-semibold mt-2"
  
  >
    Related Files
  </p>
<div v-for="relatedFile in file?.related_files">
<a 
class="text-primary underline "
v-if=" relatedFile.path "
target="_blank":href="relatedFile.path"
>
{{ relatedFile.refnum }}
</a>
<p v-else>
{{ relatedFile.refnum }}

</p>
</div>
</div>
 </div>

</template>