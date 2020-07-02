<template>
    <span>{{ timestamp }}</span>
</template>

<script>
    import moment from 'moment';

    export default {
        props: [
            'format'
        ],

        data() {
            return {
                timestamp: ''
            };
        },

        mounted() {
            this.setTimestamp();
            setInterval(this.setTimestamp, 1000);
        },

        methods: {
            setTimestamp() {
                this.timestamp = moment().format(this.format);
            }
        }
    }
</script>
