<template>
    <div class="mb-3 cursor-pointer hover:bg-gray-100">
         <div class="flex items-center gap-3 py-2 px-3">
           <img :src="image" alt="" class="w-[34px] rounded-full">
       <div>
           <h3 class="font-black text-lg">{{ title }}</h3>
       </div>
         </div>
   </div>
</template>
<script setup>
defineProps({
image:String,
title:String,
})
</script>
<style lang="">

</style>