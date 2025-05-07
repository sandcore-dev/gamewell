<script setup>
const model = defineModel();

defineProps({
    type: {
        type: String,
        default: 'text',
    },

    autofocus: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
  <input
    class="bg-white text-black font-bold p-1 min-w-full"
    :type="type"
    v-model="model"
    :autofocus="autofocus"
  >
</template>
