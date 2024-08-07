<template>
	<Teleport to="body">
		<TransitionRoot appear :show="show" as="template">
			<Dialog as="div" @close="closeModal" class="relative z-10">
				<TransitionChild
					as="template"
					enter="duration-300 ease-out"
					enter-from="opacity-0"
					enter-to="opacity-100"
					leave="duration-200 ease-in"
					leave-from="opacity-100"
					leave-to="opacity-0"
				>
					<div class="fixed inset-0 bg-black/25" />
				</TransitionChild>

				<div class="fixed inset-0 overflow-y-auto">
					<div
						class="flex min-h-full items-center justify-center p-4 text-center"
					>
						<TransitionChild
							as="template"
							enter="duration-300 ease-out"
							enter-from="opacity-0 scale-95"
							enter-to="opacity-100 scale-100"
							leave="duration-200 ease-in"
							leave-from="opacity-100 scale-100"
							leave-to="opacity-0 scale-95"
						>
							<DialogPanel
								class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
							>
								<DialogTitle
									as="h3"
									class="text-lg font-medium leading-6 text-gray-900"
								>
									Update Post
								</DialogTitle>
								<PostUserHeader :post="post" :showTime="false" />
								<div class="mt-2">
									<p class="text-sm text-gray-500">
										<InputTextarea
											v-model="form.body"
											placeholder="Click here to make post"
											class="w-full mb-3"
										>
										</InputTextarea>
									</p>
								</div>

								<div class="mt-4">
									<button
										type="button"
										class="flex items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 w-full"
										@click="submit"
									>
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
import {
	TransitionRoot,
	TransitionChild,
	Dialog,
	DialogPanel,
	DialogTitle,
} from "@headlessui/vue";
import { useForm } from "@inertiajs/vue3";

function closeModal() {
	show.value = false;
}

const props = defineProps({
	post: {
		type: Object,
		required: true,
	},
	modelValue: Boolean,
});
const form = useForm({
	id: null,
	body: "",
});

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
	form.put(route("post.update", props.post), {
		onSuccess: () => {
			show.value = false;
		},
	});
}
</script>
