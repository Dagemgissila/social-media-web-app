<template>
	<Teleport to="body">
		<TransitionRoot appear :show="show" as="template">
			<Dialog as="div" @close="closeModal" class="relative z-10">
				<TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
					enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
					<div class="fixed inset-0 bg-black/25" />
				</TransitionChild>

				<div class="fixed inset-0 overflow-y-auto">
					<div class="flex min-h-full items-center justify-center p-4 text-center">
						<TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
							enter-to="opacity-100 scale-100" leave="duration-200 ease-in"
							leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
							<DialogPanel
								class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
								<DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
									{{ form.id ? "Update Form" : "Create Post" }}
								</DialogTitle>
								<PostUserHeader :post="post" :showTime="false" />
								<ckeditor v-model="form.body" :editor="editor" :config="editorConfig" />


								<!-- attachment  -->


								<div class="grid gap-2 my-3" :class="[
			attachmentFiles.length==1 ? 'grid-cols-1' : 'grid-cols-2'
		]">
									<template v-for="myFile in attachmentFiles" :key="myFile.id">
										<div
											class="group aspect-square bg-blue-100 flex flex-col items-center justify-center relative">
                                          
											<button @click="removeFile(myFile)"
												class="absolute right-1 top-1 w-7 h-7 flex items-center justify-center bg-red-500/80 text-white rounded-full">
												<XMarkIcon class="h-5 w-5" />
											</button>
											<img v-if="isImage(myFile.file)" :src="myFile.url"
												class="object-cover aspect-square" alt="" />

											<!-- attachment  -->
											<template v-else>
												<PaperClipIcon class="w-10 h-10 mbp3" />

												<small class="text-center">{{ myFile.file.name }}</small>
											</template>
										</div>
									</template>
								</div>


								<!-- end attachemnt  -->

								<div class="flex gap-2 mt-4">
									<button type="button"
										class="relative flex items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 w-full"
										@click="submit">
										<PaperClipIcon class="w-4 h-4 mr-2" />
										Attach Files
										<input @click.stop @change="onAttachmentChange" type="file" multiple
											class="absolute top-2 right-0 left-0 bottom-0 opacity-0">
									</button>

									<button type="button"
										class="flex items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 w-full"
										@click="submit">
										<BookmarkIcon class="w-4 h-4 mr-2" />

										Submit
									</button>
								</div>
							</DialogPanel>
						</TransitionChild>
					</div>
				</div>
			</Dialog>
		</TransitionRoot>
	</Teleport>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import InputTextarea from "../InputTextarea.vue";
import PostUserHeader from "./PostUserHeader.vue";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { PaperClipIcon, BookmarkIcon, XMarkIcon } from '@heroicons/vue/20/solid'

import {
	TransitionRoot,
	TransitionChild,
	Dialog,
	DialogPanel,
	DialogTitle,
} from "@headlessui/vue";
import { useForm } from "@inertiajs/vue3";
import { isImage } from "@/helpers";

const editor = ref(ClassicEditor);
const editorData = ref('<p>Hello from CKEditor 5 in Vue!</p>');

// Define editor configuration
const editorConfig = ref({

	toolbar: ['bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'heading', '|', 'outdent', 'indent', '|', 'link', '|', 'blockQuote'],

});


function closeModal() {
	show.value = false;
	form.reset();
	attachmentFiles.value=[]
}

const props = defineProps({
	post: {
		type: Object,
		required: false,
	},
	modelValue: Boolean,
});
const form = useForm({
	id: null,
	body: "",
	attachments: [],
});

const attachmentFiles = ref([])

async function onAttachmentChange($event) {
	for (const file of $event.target.files) {
		const myFile = {
			file,
			url: await readFile(file)
		}
		attachmentFiles.value.push(myFile)
	}
	$event.target.value = null;
}

async function readFile(file) {
	return new Promise((res, rej) => {
		if (isImage(file)) {
			const reader = new FileReader();
			reader.onload = () => {
				res(reader.result)
			}
			reader.onerror = rej
			reader.readAsDataURL(file)
		} else {
			res(null)
		}
	})
}


function removeFile(myFile) {
	if (myFile.file) {
		attachmentFiles.value = attachmentFiles.value.filter(f => f !== myFile)
	} else {
		form.deleted_file_ids.push(myFile.id)
		myFile.deleted = true
	}
}



watch(
	() => props.post,
	() => {
		(form.id = props.post.id), (form.body = props.post.body);
	}
);

const show = computed({
	get: () => props.modelValue,
	set: (value) => emit("update:modelValue", value),
});
const emit = defineEmits(["update:modelValue", false]);

function submit() {
	form.attachments = attachmentFiles.value.map(myFile => myFile.file)
	if (form.id) {
		form.put(route("post.update", props.post), {
			onSuccess: () => {
				form.reset()
				show.value = false;
			},
		});
	}
	else {
		form.post(route('post.create'), {
			onSuccess: () => {
				form.reset()
				show.value = false;
			}
		})
	}

}
</script>
