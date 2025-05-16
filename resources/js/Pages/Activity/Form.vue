<script setup>
import Layout from '@/Layouts/Layout.vue';
import TitleBar from '@/Components/TitleBar.vue';
import { useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/Form/Input.vue';
import FormButton from '@/Components/Form/Button.vue';

const props = defineProps({
    titleBar: {
        type: String,
        required: true,
    },

    started_at: {
        type: String,
        required: true,
    },

    stopped_at: {
        type: [String, null],
        default: null,
    },

    url: {
        type: String,
        required: true,
    },

    cancelUrl: {
        type: String,
        required: true,
    },
});

console.log({ ...props });

const form = useForm({
    started_at: props.started_at,
    stopped_at: props.stopped_at,
});
</script>

<template>
<Layout>
    <title-bar class="mb-3">
        {{ titleBar }}
    </title-bar>

    <form @submit.prevent="form.put(url)">
        <div class="grid grid-cols-5 gap-3 mt-3">
            <div class="text-right col-span-2">
                {{ $t('Started at') }}
            </div>
            <div class="col-span-2">
                <form-input
                    v-model="form.started_at"
                    :error="form.errors.started_at"
                    autofocus
                />
            </div>
            <div class="text-right col-span-2">
                {{ $t('Stopped at') }}
            </div>
            <div class="col-span-2">
                <form-input
                    v-model="form.stopped_at"
                    :error="form.errors.stopped_at"
                />
            </div>
            <div class="col-span-2" />
            <div class="col-span-2">
                <form-button type="submit">
                    {{ $t('Update') }}
                </form-button>
                <form-button
                    class="ml-3 bg-neutral-300"
                    :href="cancelUrl"
                >
                    {{ $t('Cancel') }}
                </form-button>
            </div>
        </div>
    </form>
</Layout>
</template>
