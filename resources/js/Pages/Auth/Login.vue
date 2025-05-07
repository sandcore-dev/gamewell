<script setup>
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

import Layout from '@/Layouts/Layout.vue';
import TitleBar from '@/Components/TitleBar.vue';
import FormInput from '@/Components/Form/Input.vue';
import FormButton from '@/Components/Form/Button.vue';

const form = useForm({
    email: null,
    password: null,
    remember: null,
});
</script>

<template>
  <layout>
    <title-bar>
      {{ $t('Login') }}
    </title-bar>

    <form @submit.prevent="form.post(route('login.attempt'))">
      <div class="grid grid-cols-5 gap-3 mt-3">
        <div class="text-right col-span-2">
          {{ $t('E-mail address') }}
        </div>
        <div class="col-span-2">
          <form-input
            v-model="form.email"
            autofocus
          />
        </div>
        <div class="text-right col-span-2">
          {{ $t('Password') }}
        </div>
        <div class="col-span-2">
          <form-input
            type="password"
            v-model="form.password"
          />
        </div>
        <div class="col-span-2" />
        <div class="col-span-2">
          <label>
            <input
              type="checkbox"
              v-model="form.remember"
            >
            {{ $t('Remember me') }}
          </label>
        </div>
        <div class="col-span-2" />
        <div class="col-span-2">
          <form-button type="submit">
            {{ $t('Submit') }}
          </form-button>
        </div>
      </div>
    </form>
  </layout>
</template>
