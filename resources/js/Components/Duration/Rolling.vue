<script setup>
import { DateTime } from 'luxon';
import { onMounted, ref } from 'vue';

const props = defineProps({
    startTime: {
        type: String,
        required: true,
    },
});

const duration = ref();

function setDuration() {
    const diff = DateTime.now().diff(
        DateTime.fromISO(props.startTime),
        ['years', 'months', 'days', 'hours', 'minutes', 'seconds', 'milliseconds'],
    );
    duration.value = (diff.years ? `${diff.years}y ` : '')
        + (diff.months ? `${diff.months}mn ` : '')
        + (diff.days ? `${diff.days}d ` : '')
        + (diff.hours ? `${diff.hours}h ` : '')
        + (diff.minutes ? `${diff.minutes}m ` : '')
        + (diff.seconds ? `${diff.seconds}s` : '');
}

onMounted(() => {
    setDuration();
    setInterval(setDuration, 1000);
});
</script>

<template>
    <span>{{ duration }}</span>
</template>
