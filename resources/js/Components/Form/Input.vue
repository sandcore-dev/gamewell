<script setup>
import Error from '@/Components/Form/Error.vue';

const model = defineModel();

defineProps({
    type: {
        type: String,
        default: 'text',
    },

    error: {
        type: [String, null],
        default: null,
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
    <error :feedback="error"/>
</template>
