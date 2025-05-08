<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        default: '',
    },
});
</script>

<template>
  <div class="flex flex-column bg-cyan-400 text-black font-bold text-3xl px-2 py-1">
      <div class="grow">
          <template v-if="!href">
              <slot />
          </template>
          <template v-else>
              <Link :href="href" class="hover:text-white">
                  <slot/>
              </Link>
          </template>
      </div>
      <div class="text-white">
          <slot name="right"/>
      </div>
  </div>
</template>
