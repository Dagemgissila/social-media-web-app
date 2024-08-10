<template>
	<div class="h-full flex-1 overflow-auto">
		<PostItem v-for="post in posts" :key="post.id"
		 :post="post" @editClick="openEditModal"
		 @attachmentClick="openAttachmentPreviewModal" />
		<PostModal :post="editPost" v-model="showEditModal" @hide="onModalHide"/>
		<AttachmentPreviewModal :attachments="previewAttachmentsPost.post?.attachments || []"
                                v-model:index="previewAttachmentsPost.index"
                                v-model="showAttachmentsModal"/>
	</div>

</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import PostItem from "./PostItem.vue";
import PostModal from "./PostModal.vue";
import AttachmentPreviewModal from "./AttachmentPreviewModal.vue";
import { ref } from "vue";

const authUser = usePage().props.auth.user;
const showEditModal = ref(false)
const showAttachmentsModal = ref(false)
const editPost = ref({})
const previewAttachmentsPost = ref({})
const loadMoreIntersect = ref(null)


function openEditModal(post) {
	editPost.value = post;
	showEditModal.value = true;
}
function onModalHide() {
    editPost.value = {
        id: null,
        body: '',
        user: authUser
    }
}

function openAttachmentPreviewModal(post, index) {
    previewAttachmentsPost.value = {
        post,
        index
    }
    showAttachmentsModal.value = true;
}

defineProps({
	posts: {
		type: Array
	}
})

</script>
<style lang="">

</style>