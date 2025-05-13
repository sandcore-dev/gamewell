<script setup>
import Layout from '@/Layouts/Layout.vue';
import TitleBar from '@/Components/TitleBar.vue';
import { route } from 'ziggy-js';
import FormInput from '@/Components/Form/Input.vue';
import FormButton from '@/Components/Form/Button.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    method: {
        type: String,
        default: 'post',
    },

    url: {
        type: String,
        required: true,
    },

    titleBar: {
        type: String,
        required: true,
    },

    buttonLabel: {
        type: String,
        required: true,
    },

    name: {
        type: String,
        default: '',
    },

    order: {
        type: Number,
        default: 1,
    },

    game: {
        type: String,
        required: true,
    },
});

const form = useForm({
    name: props.name,
    order: props.order,
});
</script>

<template>
<Layout>
    <title-bar class="mb-3">
        {{ titleBar }}
    </title-bar>

    <form @submit.prevent="form.submit(method, url)">
        <div class="grid grid-cols-5 gap-3 mt-3">
            <div class="text-right col-span-2">
                {{ $t('Name') }}
            </div>
            <div class="col-span-2">
                <form-input
                    v-model="form.name"
                    :error="form.errors.name"
                    autofocus
                />
            </div>
            <div class="text-right col-span-2">
                {{ $t('Order') }}
            </div>
            <div class="col-span-2">
                <form-input
                    v-model="form.order"
                    :error="form.errors.order"
                />
            </div>
            <div class="col-span-2" />
            <div class="col-span-2">
                <form-button type="submit">
                    {{ buttonLabel }}
                </form-button>
                <form-button class="ml-3 bg-neutral-300" :href="route('game.show', { game })">
                    {{ $t('Cancel') }}
                </form-button>
            </div>
        </div>
    </form>
</Layout>
</template>
