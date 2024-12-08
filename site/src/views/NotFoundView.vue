<template>
  <MainContent disable-panels :title="$t('page.not_found')">
    <div class="flex flex-col items-center gap-8 my-6">
      <h2 class="text-3xl">{{ $t('page.not_found') }}</h2>
      <button class="btn btn-primary btn-md" @click="page.goHome(false)">
        {{ $t('action.back_home') }}
      </button>
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import { usePage } from '@/utils'

const page = usePage()
</script>
