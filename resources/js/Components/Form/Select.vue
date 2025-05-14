<script setup>
import Error from '@/Components/Form/Error.vue';

const model = defineModel();

defineProps({
    error: {
        type: [String, null],
        default: null,
    },

    options: {
        type: Array,
        required: true,
    },

    valueField: {
        type: String,
        default: 'value',
    },

    textField: {
        type: String,
        default: 'text',
    },

    autofocus: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <select
        class="bg-white text-black font-bold p-1 min-w-full p-2"
        v-model="model"
        :autofocus="autofocus"
    >
        <option
            v-for="(option) in options"
            :key="option[valueField] || option[textField]"
            :value="option[valueField] || option[textField]"
        >
            {{ option[textField] || option[valueField] }}
        </option>
    </select>
    <error :feedback="error"/>
</template>
