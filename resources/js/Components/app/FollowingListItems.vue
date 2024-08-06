<template>
<div>
    <TextInput
            :model-value="searchKeyWord"
            placeholder="Type to search"
            class="w-full my-2"
        />

        <div class="py-8 h-[300px]  lg:flex-1 overflow-auto">
            <div v-if="false" class="text-gray-400 flex text-center">
                You Dont have any friend List
            </div>

            <div v-else>
                <FollowingItem
                    image="https://picsum.photos/100"
                    title="John Doe"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    title="Elen Mask"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    title="John Doe"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    title="Elen Mask"
                />
            </div>
        </div>
</div>
</template>

<script setup>
import GroupItem from "@/Components/app/GroupItem.vue";
import TextInput from "@/Components/TextInput.vue";
import FollowingItem from "@/Components/app/FollowingItem.vue";
import { ref } from "vue";
const searchKeyWord = ref("");

</script>

<style lang="scss" scoped>

</style>