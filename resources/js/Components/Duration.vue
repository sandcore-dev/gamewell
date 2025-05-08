<script setup>
import { computed } from 'vue';
import { Duration } from 'luxon';

const props = defineProps({
    value: {
        type: Number,
        required: true,
    },
});

const formatted = computed(() => {
    const duration = Duration.fromMillis(props.value * 1000)
        .shiftTo('years', 'months', 'days', 'hours', 'minutes', 'seconds')
        .toObject();
    return (duration.years ? `${duration.years}y ` : '')
        + (duration.months ? `${duration.months}mn ` : '')
        + (duration.days ? `${duration.days}d ` : '')
        + (duration.hours ? `${duration.hours}h ` : '')
        + (duration.minutes ? `${duration.minutes}m ` : '')
        + (duration.seconds ? `${duration.seconds}s` : '');
});
</script>

<template>
    <span>
        {{ formatted }}
    </span>
</template>
