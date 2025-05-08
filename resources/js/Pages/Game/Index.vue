<script setup>
import { route } from 'ziggy-js';
import Layout from '@/Layouts/Layout.vue';
import TitleBar from '@/Components/TitleBar.vue';
import Anchor from '@/Components/Anchor.vue';
import Duration from '@/Components/Duration.vue';

defineProps({
    gamesByFirstLetter: {
        type: [Object, Array],
        default: () => ([]),
    },
});
</script>

<template>
    <Layout>
        <div class="text-center mb-3">
            <anchor :href="route('game.create')">
                {{ $t('Add game') }}
            </anchor>
        </div>
        <div v-for="(games, firstLetter) in gamesByFirstLetter" :key="firstLetter" class="mb-3">
            <title-bar class="mb-3">
                {{ firstLetter }}
            </title-bar>
            <div
                v-for="({ id, name, slug, duration }) in games"
                :key="id"
                class="flex flex-column mb-1"
            >
                <div class="grow">
                    <anchor :href="route('game.show', { slug })">
                        {{ name }}
                    </anchor>
                </div>
                <div>
                    <duration :value="duration"/>
                </div>
            </div>
        </div>
    </Layout>
</template>
