<template>
	<div class="h-full flex-1 overflow-auto">
		<PostItem v-for="post in posts" :key="post.id" :post="post" @editClick="openEditModal" />
		<PostModal :post="editPost" v-model="showEditModal" @hide="onModalHide"/>
	</div>

</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import PostItem from "./PostItem.vue";
import PostModal from "./PostModal.vue";
import { ref } from "vue";
const showEditModal = ref(false)

const editPost = ref({

})

function openEditModal(post) {
	editPost.value = post;
	showEditModal.value = true;
}
const authUser = usePage().props.auth.user;
function onModalHide() {
    editPost.value = {
        id: null,
        body: '',
        user: authUser
    }
}

defineProps({
	posts: {
		type: Array
	}
})

</script>
<style lang="">

</style>