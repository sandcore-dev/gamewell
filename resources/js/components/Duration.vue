<template>
    <span>{{ duration }}</span>
</template>

<script>
import { DateTime } from 'luxon';

export default {
    props: [
        'startTime',
    ],

    data() {
        return {
            duration: '',
        };
    },

    mounted() {
        this.setDuration();
        setInterval(this.setDuration, 1000);
    },

    methods: {
        setDuration() {
            const diff = DateTime.now().diff(
                DateTime.fromSQL(this.startTime),
                ['years', 'months', 'days', 'hours', 'minutes', 'seconds', 'milliseconds'],
            );
            this.duration = (diff.years ? `${diff.years}y ` : '')
                    + (diff.months ? `${diff.months}mn ` : '')
                    + (diff.days ? `${diff.days}d ` : '')
                    + (diff.hours ? `${diff.hours}h ` : '')
                    + (diff.minutes ? `${diff.minutes}m ` : '')
                    + (diff.seconds ? `${diff.seconds}s` : '');
        },
    },
};
</script>
