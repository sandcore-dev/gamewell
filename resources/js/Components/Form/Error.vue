<script setup>
defineProps({
    feedback: {
        type: [String, null],
        default: null,
    },
});
</script>

<template>
    <small class="block text-red-500 font-bold" v-show="feedback">
        {{ feedback }}
    </small>
</template>
