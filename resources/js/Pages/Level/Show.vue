<script setup>
import Layout from '@/Layouts/Layout.vue';
import TitleBar from '@/Components/TitleBar.vue';
import Duration from '@/Components/Duration.vue';
import Anchor from '@/Components/Anchor.vue';
import { route } from 'ziggy-js';

defineProps({
    level: {
        type: Number,
        required: true,
    },

    name: {
        type: String,
        required: true,
    },

    duration: {
        type: Number,
        required: true,
    },

    game: {
        type: Object,
        required: true,
    },

    statuses: {
        type: Array,
        required: true,
    },
});
</script>

<template>
<Layout>
    <div class="flex flex-column mb-3">
        <div class="flex-grow">
            <anchor :href="route('game.show', { game })">
                {{ game.name }}
            </anchor>
        </div>
        <div>
            <anchor :href="route('status.create', { game, level })">
                {{ $t('Add status') }}
            </anchor>
        </div>
    </div>

    <title-bar class="mb-3" :href="route('level.edit', { game, level })">
        <template #default>
            {{ name }}
        </template>
        <template #right>
            <duration :value="duration"/>
        </template>
    </title-bar>

    <div v-for="({ id, attempt, status, duration }) in statuses" :key="id" class="flex flex-column">
        <div class="grow">
            <anchor :href="route('status.show', { game, level, status: id })">
                {{ $t('Attempt :attempt', { attempt }) }}
            </anchor>
            <span class="text-cyan-400 font-bold ml-3">{{ status }}</span>
        </div>
        <div>
            <duration :value="duration"/>
        </div>
    </div>
</Layout>
</template>
