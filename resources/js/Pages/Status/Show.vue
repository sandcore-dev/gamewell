<script setup>
import { DateTime } from 'luxon';
import { route } from 'ziggy-js';
import Anchor from '@/Components/Anchor.vue';
import Layout from '@/Layouts/Layout.vue';
import Duration from '@/Components/Duration.vue';
import TitleBar from '@/Components/TitleBar.vue';

defineProps({
    game: {
        type: Object,
        required: true,
    },

    level: {
        type: Object,
        required: true,
    },

    attempt: {
        type: Number,
        required: true,
    },

    status: {
        type: String,
        required: true,
    },

    activities: {
        type: Array,
        required: true,
    },
});

function formatDate(isoTimestamp) {
    return DateTime.fromISO(isoTimestamp)
        .setLocale('en')
        .toFormat('ccc dd LLL yyyy HH:mm:ss');
}

function getDuration(start, end) {
    return DateTime.fromISO(end)
        .diff(DateTime.fromISO(start), 'seconds')
        .toMillis() / 1000;
}
</script>

<template>
<Layout>
    <div class="grid grid-cols-3 mb-3">
        <div>
            <anchor :href="route('game.show', game)">
                {{ game.name }}
            </anchor>
        </div>
        <div class="text-center">
            {{ $t('Start') }}
        </div>
        <div class="text-right">
            <anchor :href="route('level.show', { game, level })">
                {{ level.name }}
            </anchor>
        </div>
    </div>

    <title-bar class="mb-3">
        {{ $t('Attempt :attempt', { attempt }) }} ({{ status }})
    </title-bar>

    <div v-for="(activity) in activities" :key="activity.id" class="grid grid-cols-5">
        <div class="col-span-2">
            {{ formatDate(activity.started_at) }}
        </div>
        <div class="col-span-2">
            {{ formatDate(activity.stopped_at) }}
        </div>
        <div class="text-right">
            <duration :value="getDuration(activity.started_at, activity.stopped_at)"/>
        </div>
    </div>
</Layout>
</template>
