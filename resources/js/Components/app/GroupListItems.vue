<template>
  	<TextInput :model-value="searchKeyWord" placeholder="Type to search" class="w-full my-2" />

<div class="py-8 h-[300px]  lg:flex-1 overflow-auto">
    <div v-if="false" class="text-gray-400 flex text-center">
        You are not joined any group
    </div>

    <div v-else>
        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />

        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />

        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />

        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />

        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />

        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />

        <GroupItem image="https://picsum.photos/100" title="Laravel Developer" description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
    </div>
</div>
</template>

<script setup>
	import { ref } from "vue";
	import GroupItem from "@/Components/app/GroupItem.vue";
	import TextInput from "@/Components/TextInput.vue";
	const searchKeyWord = ref("");

</script>

<style lang="scss" scoped>

</style>