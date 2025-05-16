<script setup>
import { useForm } from '@inertiajs/vue3';
import { DateTime } from 'luxon';
import { route } from 'ziggy-js';

import Anchor from '@/Components/Anchor.vue';
import Duration from '@/Components/Duration.vue';
import DurationRolling from '@/Components/Duration/Rolling.vue';
import Layout from '@/Layouts/Layout.vue';
import TitleBar from '@/Components/TitleBar.vue';
import Now from '@/Components/Now.vue';

const props = defineProps({
    game: {
        type: Object,
        required: true,
    },

    level: {
        type: Object,
        required: true,
    },

    status: {
        type: Object,
        required: true,
    },

    activities: {
        type: Array,
        required: true,
    },

    updatedActivityId: {
        type: Number,
        default: 0,
    },

    ongoingActivityId: {
        type: Number,
        default: 0,
    },
});

const form = useForm();

function formatDate(isoTimestamp) {
    return isoTimestamp
        && DateTime.fromISO(isoTimestamp)
            .setLocale('en')
            .toFormat('ccc dd LLL yyyy HH:mm:ss');
}

function getDuration(start, end) {
    return start
        && end
        && DateTime.fromISO(end)
            .diff(DateTime.fromISO(start), 'seconds')
            .toMillis() / 1000;
}

function startActivity() {
    const { game, level, status } = props;
    form.post(route('activity.store', { game, level, status }));
}

function stopActivity() {
    const {
        game,
        level,
        status,
        ongoingActivityId: activity,
    } = props;

    form.patch(
        route('activity.stop', {
            game, level, status, activity,
        }),
    );
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
                <template v-if="status.status === 'ongoing'">
                    <form @submit.prevent="startActivity()" v-show="!ongoingActivityId">
                        <button type="submit" class="font-bold text-lime-400 cursor-pointer">
                            {{ $t('Start') }}
                        </button>
                    </form>
                    <form @submit.prevent="stopActivity()" v-show="ongoingActivityId">
                        <button type="submit" class="font-bold text-red-600 cursor-pointer">
                            {{ $t('Stop') }}
                        </button>
                    </form>
                </template>
            </div>
            <div class="text-right">
                <anchor :href="route('level.show', { game, level })">
                    {{ level.name }}
                </anchor>
            </div>
        </div>

        <title-bar class="mb-3" :href="route('status.edit', { game, level, status })">
            {{ $t('Attempt :attempt', status) }} ({{ status.status }})
        </title-bar>

        <div
            v-for="(activity) in activities"
            :key="activity.id"
            :class="{
                grid: true,
                'grid-cols-5': true,
                'mb-1': true,
                'animate-[highlight-fade_4s_ease-out]': activity.id === updatedActivityId,
            }"
        >
            <div class="col-span-2">
                <anchor :href="route('activity.edit', { game, level, status, activity })">
                    {{ formatDate(activity.started_at) }}
                </anchor>
            </div>
            <div class="col-span-2">
                <anchor
                    v-if="!!activity.stopped_at"
                    :href="route('activity.edit', { game, level, status, activity })"
                >
                    {{ formatDate(activity.stopped_at) }}
                </anchor>
                <now v-else/>
            </div>
            <div class="text-right">
                <duration
                    v-if="!!activity.stopped_at"
                    :value="getDuration(activity.started_at, activity.stopped_at)"
                />
                <duration-rolling
                    v-else
                    :start-time="activity.started_at"
                />
            </div>
        </div>
    </Layout>
</template>

<style>
@keyframes highlight-fade {
    from {
        background-color: var(--color-cyan-400);
    }
    to {
        background-color: transparent;
    }
}
</style>
