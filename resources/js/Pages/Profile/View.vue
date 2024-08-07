<template>
    <AuthenticatedLayout>
        <div class="w-[900px] mx-auto h-full overflow-auto">
            <div v-show="showNotification && status === 'cover-image-update'"
                class="mt-2 py-2 px-3 font-medium bg-green-600 text-white">
                cover image updated
            </div>
            <div v-show="errors.cover"
                class="mt-2 py-2 px-3 font-medium bg-red-600 text-white">
                {{ errors.cover }}
            </div>
            <div class="relative group bg-white">

                <img :src="coverImageSrc || user.cover_url || '/img/default_image.jpg'"
                    class="w-full object-cover h-[200px]" alt="" />
                <div class="absolute top-2 right-2">
                    <button v-if="!coverImageSrc"
                        class="cursor-pointer  opacity-0 group-hover:opacity-100 flex items-center  bg-gray-50 hover:bg-gray-100 text-gray-800 py-1 px-2 text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>

                        Update Cover Image
                        <input type="file" class="absolute opacity-0 top-0 right-0 left-0 bottom-0 "
                            @change="onCoverImage" name="" id="">
                    </button>

                    <template v-else>
                        <button @click="cancelCoverImage"
                            class="cursor-pointer inline-flex  opacity-0 group-hover:opacity-100  items-center  bg-gray-50 hover:bg-gray-100 text-gray-800 py-1 px-2 text-xs">
                            <XMarkIcon class="size-3" />

                            Cancel
                        </button>

                        <button @click="submitCoverImage"
                            class="cursor-pointer inline-flex  opacity-0 group-hover:opacity-100 flex items-center  bg-gray-800 hover:bg-gray-900 text-white py-1 px-2 text-xs">
                            <CheckCircleIcon class="size-3" />
                            Submit
                        </button>
                    </template>
                </div>
                <div class="flex">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQoqWIPKg9kRQhn9r3qgpcRSACAXvg-dbTOWQiDN6b5ahLRZ-AU_ioL_uXv5Un0kNGPNhE&usqp=CAU"
                        class="ml-[48px] -mt-[64px] rounded-full h-[128px] w-[128px]" alt="" />

                    <div class="flex flex-1 justify-between items-center p-3">
                        <h2 class="font-bold">{{ user.name }}</h2>
                        <PrimaryButton v-if="isMyprofile">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>

                            Edit Profile
                        </PrimaryButton>
                    </div>
                </div>
            </div>
            <div class="border-t">
                <TabGroup>
                    <TabList class="flex bg-white">
                        <Tab v-if="isMyprofile" v-slot="{ selected }">
                            <Tabitem text="About" :selected="selected" />
                        </Tab>
                        <Tab as="template" v-slot="{ selected }">
                            <Tabitem text="Posts" :selected="selected" />
                        </Tab>

                        <Tab as="template" v-slot="{ selected }">
                            <Tabitem text="Followers" :selected="selected" />
                        </Tab>
                        <Tab as="template" v-slot="{ selected }">
                            <Tabitem text="Following" :selected="selected" />
                        </Tab>

                        <Tab as="template" v-slot="{ selected }">
                            <Tabitem text="Photos" :selected="selected" />
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">


                        <TabPanel v-if="isMyprofile" :must-verify-email="mustVerifyEmail" class="p-3">
                            <Edit />
                        </TabPanel>
                        <TabPanel class="bg-white p-3"> Posts </TabPanel>
                        <TabPanel class="bg-white p-3"> Followers </TabPanel>
                        <TabPanel class="bg-white p-3"> Following </TabPanel>
                        <TabPanel class="bg-white p-3"> Photos </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed, ref } from "vue";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Edit from "../Profile/Edit.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { usePage } from "@inertiajs/vue3";
import Tabitem from "./Partials/Tabitem.vue";
import { XMarkIcon, CheckCircleIcon } from "@heroicons/vue/24/solid"
import { useForm } from '@inertiajs/vue3'

const authUser = usePage().props.auth.user;

const isMyprofile = computed(() => authUser && authUser.id == props.user.id)
const coverImageSrc = ref('');
const showNotification=ref(true)
const imagesForm = useForm({
    cover: null,
    avatar: null,
})

const props = defineProps({
    errors: {
        type: Object
    },
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: {
        type: Object,
    },
});

function onCoverImage(event) {
    imagesForm.cover = event.target.files[0]
    if (imagesForm.cover) {
        const reader = new FileReader();
        reader.onload = () => {
            console.log("onload")
            coverImageSrc.value = reader.result
        }
        reader.readAsDataURL(imagesForm.cover)
    }
}

function cancelCoverImage() {
    coverImageSrc.value = null;
    imagesForm.cover = null;
}

function submitCoverImage() {
    imagesForm.post(route('profile.updateImages'),{
        onSuccess:(user)=>{
            cancelCoverImage();
            setTimeout(()=>{
            showNotification.value=false
            },5000)
        }
    });
}
</script>
