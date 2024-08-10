<template>
	<div class="bg-white rounded border p-4 mb-3">

		<div class="flex items-center justify-between gap-2 mb-3">
			<PostUserHeader :post="post" />

			<div>
				<Menu as="div" class="relative inline-block text-left z-50">
					<div>
						<MenuButton
							class="w-8 h-8 rounded-full hover:bg-black/20 transition flex items-center justify-center">
							<EllipsisVerticalIcon class="w-4 h-4" aria-hidden="true" />
						</MenuButton>
					</div>

					<transition enter-active-class="transition duration-100 ease-out"
						enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
						leave-active-class="transition duration-75 ease-in"
						leave-from-class="transform scale-100 opacity-100"
						leave-to-class="transform scale-95 opacity-0">
						<MenuItems
							class="absolute right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
							<div class="px-1 py-1">
								<MenuItem v-slot="{ active }">
								<button @click="openEditModal" :class="[
									active ? 'bg-indigo-600 text-white' : 'text-gray-900',
									'group flex w-full items-center rounded-md px-2 py-2 text-sm',
								]">
									<PencilIcon class="mr-2 h-5 w-5" aria-hidden="true" />
									Edit
								</button>
								</MenuItem>


								<MenuItem v-slot="{ active }">
								<button @click="deletePost" :class="[
									active ? 'bg-violet-500 text-white' : 'text-gray-900',
									'group flex w-full items-center rounded-md px-2 py-2 text-sm',
								]">
									<TrashIcon class="mr-2 h-5 w-5" aria-hidden="true" />
									Delte
								</button>
								</MenuItem>

							</div>

						</MenuItems>
					</transition>
				</Menu>


			</div>
		</div>
		<Disclosure v-slot="{ open }">
			<div class="ck-content" v-if="!open" v-html="post.body.substring(0, 200)"></div>

			<template v-if="post.body.length >= 200">
				<DisclosurePanel class="">
					<div class="ck-content" v-html="post.body"></div>
				</DisclosurePanel>
				<div class="flex justify-end">
					<DisclosureButton class="text-blue-300 hover:underline">
						{{ open ? "Read Less" : "Read More" }}
					</DisclosureButton>
				</div>
			</template>
		</Disclosure>

		<div class="grid gap-2 mb-3" :class="[
			post.attachments.length == 1 ? 'grid-cols-1' : 'grid-cols-2'
		]">
			<template v-for="(attachment, ind) in post.attachments.slice(0, 4)" :key="attachment.id">
				<div class="group aspect-square z-10 bg-blue-100 flex flex-col items-center justify-center relative">
					<div v-if="ind == 3" class="absolute top-0 left-0 right-0 bottom-0 z-10
											   bg-black/60 text-white text-2xl flex items-center justify-center">
						+{{ post.attachments.length - 4 }} more
					</div>
					<!-- download -->
					<a :href="route('post.download', attachment)"
						class="opacity-0 z-10 group-hover:opacity-100 transition-all w-8 h-8 flex items-center justify-center text-gray-100 bg-gray-700 hover:bg-gray-800 rounded absolute right-2 top-2 cursor-pointer">
						<ArrowDownTrayIcon class="w-5 h-5" />
					</a>

					<img v-if="isImage(attachment)" :src="attachment.url" class="object-cover aspect-square" alt="" />

					<!-- attachment  -->
					<template v-else>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-16">
							<path
								d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
							<path
								d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
						</svg>

						{{ attachment.name }}
					</template>
				</div>
			</template>
		</div>

		<div class="flex gap-2">
			<button class="flex-1 flex gap-1 items-center justify-center bg-gray-100 hover:bg-gray-200 py-2 px-4">

				<HandThumbUpIcon class="h-6 w-6" />

				like
			</button>

			<button class="flex-1 flex gap-1 items-center justify-center bg-gray-100 hover:bg-gray-200 py-2 px-4">
				<ChatBubbleLeftRightIcon class="h-6 w-6" />

				comment
			</button>
		</div>
	</div>
	<!-- model  -->
</template>

<style lang=""></style>


<script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { ChevronDownIcon, PencilIcon, TrashIcon, EllipsisVerticalIcon, ArrowDownTrayIcon } from '@heroicons/vue/20/solid'
import { ChatBubbleLeftRightIcon, HandThumbUpIcon } from '@heroicons/vue/24/outline'

import PostUserHeader from './PostUserHeader.vue';
import { useForm, router } from "@inertiajs/vue3";
import { ref } from 'vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
// import { isImage } from '@/helpers';
const props = defineProps({
	post: Object,
});

function isImage(attachment) {
	const mime = attachment.mime.split("/");
	return mime[0].toLowerCase() == "image";
}


const emit = defineEmits(["editClick"])

function openEditModal() {
	emit("editClick", props.post)
}

function deletePost() {
	if (window.confirm("Are you sure you want to delete this post")) {
		router.delete(route("post.delete", props.post))
	}
}

</script>
