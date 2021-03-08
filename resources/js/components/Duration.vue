<template>
    <span>{{ duration }}</span>
</template>

<script>
import moment from 'moment';
import 'moment-precise-range-plugin';

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
            const diff = moment.preciseDiff(new Date(), this.startTime, true);
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
