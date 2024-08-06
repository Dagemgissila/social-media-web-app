<template>
    <div>
        {{ user }}
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
const props = usePage().props.value;
const user = props.auth.user;
</script>

<style>
</style>
