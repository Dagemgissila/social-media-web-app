<template>
    <AuthenticatedLayout>
        <div class="w-[900px] mx-auto h-full overflow-auto">
            <div class="bg-white">
                <img
                    src="https://www.prodraw.net/fb_cover/images/fb_cover_65.jpg"
                    class="w-full object-cover h-[200px]"
                    alt=""
                />
                <div class="flex">
                    <img
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQoqWIPKg9kRQhn9r3qgpcRSACAXvg-dbTOWQiDN6b5ahLRZ-AU_ioL_uXv5Un0kNGPNhE&usqp=CAU"
                        class="ml-[48px] -mt-[64px] rounded-full h-[128px] w-[128px]"
                        alt=""
                    />

                    <div class="flex flex-1 justify-between items-center p-3">
                        <h2 class="font-bold">{{ user.name }}</h2>
                        <PrimaryButton v-if="isMyprofile">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-4 mr-2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                                />
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
                    
                     
                        <TabPanel v-if="isMyprofile"  :must-verify-email="mustVerifyEmail" class="p-3">
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
const authUser = usePage().props.auth.user;

const isMyprofile=computed(()=>authUser && authUser.id==props.user.id)

const props=defineProps({
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
</script>
