<script setup>
import Layout from '@/Layouts/Layout.vue';
import TitleBar from '@/Components/TitleBar.vue';
import Duration from '@/Components/Duration.vue';
import Anchor from '@/Components/Anchor.vue';
import { route } from 'ziggy-js';

defineProps({
    title: {
        type: String,
        required: true,
    },

    slug: {
        type: String,
        required: true,
    },

    duration: {
        type: Number,
        required: true,
    },

    levels: {
        type: Array,
        required: true,
    },
});
</script>

<template>
<Layout>
    <title-bar class="mb-3" :href="route('game.edit', slug)">
        <template #default>
            {{ title }}
        </template>
        <template #right>
            <duration :value="duration"/>
        </template>
    </title-bar>

    <div
        v-for="({id: level, game, name, duration}) in levels"
        :key="level"
        class="flex flex-column"
    >
        <div class="grow">
            <anchor :href="route('levels.show', {game, level})">
                {{ name }}
            </anchor>
        </div>
        <div>
            <duration :value="duration"/>
        </div>
    </div>
</Layout>
</template>
