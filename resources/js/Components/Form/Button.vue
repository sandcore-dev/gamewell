<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    type: {
        type: String,
        default: 'button',
    },

    href: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <button
        v-if="!href"
        :type="type"
        class="bg-cyan-400 text-black font-bold py-1 px-3 hover:opacity-75"
    >
        <slot />
    </button>
    <Link
        v-else
        :href="href"
        as="button"
        class="bg-cyan-400 text-black font-bold py-1 px-3 cursor-pointer hover:opacity-75"
    >
        <slot/>
    </Link>
</template>
