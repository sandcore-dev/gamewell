<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link class="hover:text-cyan-400" :href="href">
        <slot/>
    </Link>
</template>
