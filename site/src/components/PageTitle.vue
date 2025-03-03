<template>
  <div class="page-title" :title="title">
    <div class="flex gap-2 w-full items-center">
      <button v-if="showBackButton" class="btn-text" @click="back">
        <i class="icon-4xl ti ti-arrow-left"></i>
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
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

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
const route = useRoute()
const router = useRouter()

const back = () => {
  if (!history.state.back) {
    router.push({ path: '/' })
    return
  }
  router.back()
}

const showBackButton = computed(() => props.showBack && route.fullPath !== '/')
</script>
