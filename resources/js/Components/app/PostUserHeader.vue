<template>
	<div class="flex items-center gap-2">
				<a href="javascript:void(0)">
					<img
						:src="post.user.avatar_url"
						alt="sdfjk"
						class="w-[42px] h-[42px] rounded-full border-2 transition-all hover:border-blue-500"
					/>
				</a>
				<div>
					<h4 class="font-bold">
						<a href="javascript:void(0)" class="hover:underline">{{
							post.user.name
						}}</a>
						<template v-if="post.group">
							>
							<a href="javascript:void(0)" class="hover:underline">{{
								post.group.name
							}}</a>
						</template>
					</h4>

					<small v-show="showTime" class="text-gray-400">{{ post.updated_at }}</small>
				</div>
			</div>

</template>

<script setup>

defineProps({
    post:{
        type:Object
    },
    showTime:{
        type:Boolean,
        default:true
    }
})

</script>

<style lang="scss" scoped>

</style>