<template>
    <span>{{ timestamp }}</span>
</template>

<script>
import { DateTime } from 'luxon';

export default {
    props: [
        'format',
    ],

    data() {
        return {
            timestamp: '',
        };
    },

    mounted() {
        this.setTimestamp();
        setInterval(this.setTimestamp, 1000);
    },

    methods: {
        setTimestamp() {
            this.timestamp = DateTime.now().toFormat(this.format);
        },
    },
};
</script>
