<script setup>
import { DateTime } from 'luxon';
import { onMounted, ref } from 'vue';

const props = defineProps({
    format: {
        type: String,
        default: 'ccc dd LLL yyyy HH:mm:ss',
    },
});

const timestamp = ref();

function setTimestamp() {
    timestamp.value = DateTime.now().toFormat(props.format);
}

onMounted(() => {
    setTimestamp();
    setInterval(setTimestamp, 1000);
});
</script>

<template>
    <span>{{ timestamp }}</span>
</template>
