<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
  <button
    :type="type"
    class="bg-cyan-400 text-black font-bold py-1 px-3"
  >
    <slot />
  </button>
</template>
