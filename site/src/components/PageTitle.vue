<template>
  <div class="page-title" :title="title">
    <div class="flex gap-2 w-full items-center">
      <button
        v-if="showBackButton"
        class="btn-text"
        @click="page.back"
      >
        <ArrowLeft class="size-8" />
      </button>
      <div class="flex flex-col grow">
        <slot>
          <div class="text-xl">{{ title }}</div>
        </slot>
      </div>
    </div>
    <div>
      <slot name="extra" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ArrowLeft } from '@vicons/tabler'
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { usePage } from '@/utils'

defineOptions({
  name: 'PageTitle',
})

interface PageTitleProps {
  title?: string
  showBack?: boolean
}

const props = withDefaults(defineProps<PageTitleProps>(), {
  title: '',
  showBack: true,
})
const page = usePage()
const route = useRoute()
const showBackButton = computed(() => props.showBack && route.fullPath !== '/')
</script>
