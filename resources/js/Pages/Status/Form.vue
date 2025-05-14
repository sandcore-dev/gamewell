<script setup>
import Layout from '@/Layouts/Layout.vue';
import TitleBar from '@/Components/TitleBar.vue';
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import FormInput from '@/Components/Form/Input.vue';
import FormButton from '@/Components/Form/Button.vue';
import FormSelect from '@/Components/Form/Select.vue';

const statusOptions = [
    {
        value: 'ongoing',
    },
    {
        value: 'finished',
    },
    {
        value: 'dropped',
    },
];

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
        default: 1,
    },

    status: {
        type: String,
        default: '',
    },

    buttonLabel: {
        type: String,
        required: true,
    },
});

const form = useForm({
    attempt: props.attempt,
    status: props.status,
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
                {{ $t('Attempt') }}
            </div>
            <div class="col-span-2">
                <form-input
                    v-model="form.attempt"
                    :error="form.errors.attempt"
                    type="number"
                    autofocus
                />
            </div>
            <template v-if="!!status">
                <div class="text-right col-span-2">
                    {{ $t('Status') }}
                </div>
                <div class="col-span-2">
                    <form-select
                        v-model="form.status"
                        :options="statusOptions"
                        :error="form.errors.status"
                    />
                </div>
            </template>
            <div class="col-span-2" />
            <div class="col-span-2">
                <form-button type="submit">
                    {{ buttonLabel }}
                </form-button>
                <form-button
                    class="ml-3 bg-neutral-300"
                    :href="route('level.show', { game, level })"
                >
                    {{ $t('Cancel') }}
                </form-button>
            </div>
        </div>
    </form>
</Layout>
</template>
