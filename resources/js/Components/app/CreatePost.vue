<template >
    <div class="p-4 bg-white rounded-lg mb-3 border">
           <InputTextarea @click="PostCreating=true" v-model="newPostForm.body" placeholder="Click here to make post" class=" w-full mb-3">
         
           </InputTextarea>

           <div v-if="PostCreating" class="flex gap-2 justify-between">
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold
                text-white shadow-sm hover:bg-indigo-500 focus-visible:outline
                 focus-visible:outline-2 focus-visible:outline-offset-2
                  focus-visible:outline-indigo-600 relative">
                  Attach File
                  <input type="file" class="absolute top-0 right-0 bottom-0 left-0 opacity-0">
                </button>


               <button @click="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold
                text-white shadow-sm hover:bg-indigo-500 focus-visible:outline
                 focus-visible:outline-2 focus-visible:outline-offset-2
                  focus-visible:outline-indigo-600">Submit</button>
           </div>
    </div>
</template>
<script setup>
import { ref } from "vue";
import InputTextarea from "../InputTextarea.vue";
import { useForm } from "@inertiajs/vue3";
const PostCreating=ref(false)
const newPostForm=useForm({
  body:''
})

function submit(){
    newPostForm.post(route('post.create'),{
        onSuccess:()=>{
            newPostForm.reset()
        }
    })
}
</script>
<style>
    
</style>