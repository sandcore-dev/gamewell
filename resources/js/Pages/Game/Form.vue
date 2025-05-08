<script setup>
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import Layout from '@/Layouts/Layout.vue';
import TitleBar from '@/Components/TitleBar.vue';
import FormButton from '@/Components/Form/Button.vue';
import FormInput from '@/Components/Form/Input.vue';

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

    slug: {
        type: String,
        default: '',
    },
});

const form = useForm({
    name: props.name,
    slug: props.slug,
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
            <template v-if="slug">
                <div class="text-right col-span-2">
                    {{ $t('Slug') }}
                </div>
                <div class="col-span-2">
                    <form-input
                        v-model="form.slug"
                        :error="form.errors.slug"
                        autofocus
                    />
                </div>
            </template>
            <div class="col-span-2" />
            <div class="col-span-2">
                <form-button type="submit">
                    {{ buttonLabel }}
                </form-button>
                <form-button class="ml-3 bg-neutral-300" :href="route('game.index')">
                    {{ $t('Cancel') }}
                </form-button>
            </div>
        </div>
    </form>
</Layout>
</template>
