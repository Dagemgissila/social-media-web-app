<template>
    <div class="h-full flex-1 overflow-auto">
        <PostItem v-for="post in posts" :key="post.id" :post="post" />
    
    </div>
</template>
<script setup>
import PostItem from "./PostItem.vue";
defineProps({
    posts:{
        type:Array
    }
})

</script>
<style lang="">

</style>