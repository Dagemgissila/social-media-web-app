<template lang="">
    <div
        class="px-3 bg-white rounded border py-4 overflow-hidden flex flex-col"
    >
        <div class="flex-1 lg:hidden">
            <Disclosure v-slot="{ open }">
                <DisclosureButton>
				<div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold">My Groups</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6 transition-all"
                             :class="open ? 'rotate-90 transform' : ''">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    </div>
                </DisclosureButton>

                <DisclosurePanel class="">
                    <GroupListItems/>
                </DisclosurePanel>
                <div class="flex justify-end"></div>
            </Disclosure>
        </div>

        <!-- large device  -->

        <div class="hidden lg:block">
            <h2 class="text-xl font-bold mb-4">My Groups</h2>
            <GroupListItems/>
        </div>
		
    </div>
</template>
<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";

import GroupItem from "@/Components/app/GroupItem.vue";
import GroupListItems from "@/Components/app/GroupListItems.vue";
import TextInput from "@/Components/TextInput.vue";
</script>
<style lang=""></style>
