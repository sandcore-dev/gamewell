<script setup>
import Layout from '@/Layouts/Layout.vue';
import TitleBar from '@/Components/TitleBar.vue';
import Anchor from '@/Components/Anchor.vue';

defineProps({
    activitiesByDay: {
        type: Object,
        required: true,
    },

    before: {
        type: [Object, null],
        default: null,
    },

    after: {
        type: [Object, null],
        default: null,
    },
});
</script>

<template>
<Layout>
    <div class="flex flex-column">
        <div class="flex-grow">
            <anchor :href="before.link" v-if="before">
                &laquo; {{ before.text }}
            </anchor>
        </div>
        <div>
            <anchor :href="after.link" v-if="after">
                {{ after.text }} &raquo;
            </anchor>
        </div>
    </div>
    <div v-for="(activities, day) in activitiesByDay" :key="day" class="mt-3">
        <title-bar class="mb-3">
            {{ day }}
        </title-bar>
        <div v-for="(activity) in activities" :key="activity.id" class="flex flex-column">
            <div class="flex-grow">
                <anchor :href="activity.status.level.game.slug" class="hover:text-cyan-400">
                    {{ activity.status.level.game.name }}
                </anchor>
                <span class="pl-3 font-bold text-cyan-400">
                {{ activity.status.level.name }}
                    - {{ $t('attempt :attempt', activity.status) }}
                </span>
            </div>
            <div>
                {{ activity.formatted_duration }}
            </div>
        </div>
    </div>
</Layout>
</template>
