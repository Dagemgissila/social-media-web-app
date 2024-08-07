<template>
    <AuthenticatedLayout>
        <div class="w-[900px] mx-auto h-full overflow-auto">
            <div
                v-show="showNotification && success"
                class="mt-2 py-2 px-3 font-medium bg-green-600 text-white my-1"
            >
            {{success}}
            </div>
         
          
            <div class="relative group bg-white">
                <img
                    :src="
                        coverImageSrc ||
                        user.cover_url ||
                        '/img/default_image.jpg'
                    "
                    class="w-full object-cover h-[200px]"
                    alt=""
                />
                <div class="absolute top-2 right-2">
                    <button
                        v-if="!coverImageSrc"
                        class="cursor-pointer opacity-0 group-hover:opacity-100 flex items-center bg-gray-50 hover:bg-gray-100 text-gray-800 py-1 px-2 text-xs"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-3"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"
                            />
                        </svg>

                        Update Cover Image
                        <input
                            type="file"
                            class="absolute opacity-0 top-0 right-0 left-0 bottom-0"
                            @change="onCoverImage"
                            name=""
                            id=""
                        />
                    </button>

                    <template v-else>
                        <button
                            @click="cancelCoverImage"
                            class="cursor-pointer inline-flex opacity-0 group-hover:opacity-100 items-center bg-gray-50 hover:bg-gray-100 text-gray-800 py-1 px-2 text-xs"
                        >
                            <XMarkIcon class="size-3" />

                            Cancel
                        </button>

                        <button
                            @click="submitCoverImage"
                            class="cursor-pointer inline-flex opacity-0 group-hover:opacity-100 flex items-center bg-gray-800 hover:bg-gray-900 text-white py-1 px-2 text-xs"
                        >
                            <CheckCircleIcon class="size-3" />
                            Submit
                        </button>
                    </template>
                </div>


                <div class="flex ">
           
                    <!-- update avatar  -->
                    <div
                            class="flex items-center justify-center relative group/avatar -mt-[64px] ml-[48px] w-[128px] h-[128px] rounded-full">
                            <img :src="avatarImageSrc || user.avatar_url || '/img/default_avatar.webp'"
                                 class="w-full h-full object-cover rounded-full">
                            <button
                                v-if="!avatarImageSrc"
                                class="absolute left-0 top-0 right-0 bottom-0 bg-black/50 text-gray-200 rounded-full opacity-0 flex items-center justify-center group-hover/avatar:opacity-100">
                                <CameraIcon class="w-8 h-8"/>

                                <input type="file" class="absolute left-0 top-0 bottom-0 right-0 opacity-0"
                                       @change="onAvatarImage"/>
                            </button>
                            <div v-else class="absolute top-1 right-0 flex flex-col gap-2">
                                <button
                                    @click="cancelAvatarImage"
                                    class="w-7 h-7 flex items-center justify-center bg-red-500/80 text-white rounded-full">
                                    <XMarkIcon class="h-5 w-5"/>
                                </button>
                                <button
                                    @click="submitAvatarImage"
                                    class="w-7 h-7 flex items-center justify-center bg-emerald-500/80 text-white rounded-full">
                                    <CheckCircleIcon class="h-5 w-5"/>
                                </button>
                            </div>
                        </div>

                <!-- end avatar  -->
                    <div class="flex flex-1 justify-between items-center p-3">
                        <h2 class="font-bold">{{ user.name }}</h2>
             
                    </div>
                </div>
            </div>
            <div class="border-t">
                <TabGroup>
                    <TabList class="flex bg-white">

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
                        <Tab v-if="isMyprofile" v-slot="{ selected }">
                            <Tabitem text="My Profile" :selected="selected" />
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel class="bg-white p-3"> Posts </TabPanel>
                        <TabPanel class="bg-white p-3"> Followers </TabPanel>
                        <TabPanel class="bg-white p-3"> Following </TabPanel>
                        <TabPanel class="bg-white p-3"> Photos </TabPanel>
                        <TabPanel
                            v-if="isMyprofile"
                            :must-verify-email="mustVerifyEmail"
                            class="p-3"
                        >
                            <Edit />
                        </TabPanel>
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
import { XMarkIcon, CheckCircleIcon , CameraIcon} from "@heroicons/vue/24/solid";
import { useForm } from "@inertiajs/vue3";

const authUser = usePage().props.auth.user;

const isMyprofile = computed(() => authUser && authUser.id == props.user.id);
const coverImageSrc = ref("");
const avatarImageSrc = ref("");

const showNotification = ref(true);
const imagesForm = useForm({
    cover: null,
    avatar: null,
});

const props = defineProps({
    errors: {
        type: Object,
    },
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    success:{
       type:String
    },
    user: {
        type: Object,
    },
});

function onCoverImage(event) {
    imagesForm.cover = event.target.files[0];
    if (imagesForm.cover) {
        const reader = new FileReader();
        reader.onload = () => {
            console.log("onload");
            coverImageSrc.value = reader.result;
        };
        reader.readAsDataURL(imagesForm.cover);
    }
}

function onAvatarImage(event){
    imagesForm.avatar=event.target.files[0];
    if(imagesForm.avatar){
        const reader=new FileReader();
        reader.onload=()=>{
            avatarImageSrc.value=reader.result;
        };
        reader.readAsDataURL(imagesForm.avatar);
    }
}

function cancelCoverImage() {
    coverImageSrc.value = null;
    imagesForm.cover = null;
}

function cancelAvatarImage(){
    avatarImageSrc.value=null;
    imagesForm.avatar=null
}

function submitCoverImage() {
    imagesForm.post(route("profile.updateImages"), {
        onSuccess: (user) => {
            cancelCoverImage();
            setTimeout(() => {
                showNotification.value = false;
            }, 5000);
        },
    });
}

function submitAvatarImage(){
    imagesForm.post(route('profile.updateImages'),{
         onSuccess:(user)=>{
            cancelAvatarImage();
            setTimeout(()=>{
             showNotification.value=false;
            },5000)
         }
    })
}
</script>
