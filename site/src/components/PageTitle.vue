<template>
  <div class="page-title">
    <div class="page-header">
      <div>
        <button
          v-show="showBackButton"
          class="icon-link hover-card"
          @click="router.back()"
        >
          <IconArrowLeft :size="20" />
        </button>
        <TypographyTitle :heading="5">{{ title }}</TypographyTitle>
      </div>
      <slot name="extra" />
    </div>
    <TypographyText type="secondary">
      {{ subtitle }}
    </TypographyText>
  </div>
</template>

<script setup lang="ts">
import { TypographyText, TypographyTitle } from '@arco-design/web-vue'
import '@/style/PageTitle.css'
import { IconArrowLeft } from '@arco-design/web-vue/es/icon'
import { useRouter } from 'vue-router'
import { computed } from 'vue'

defineOptions({
  name: 'PageTitle',
})

interface PageTitleProps {
  title: string
  subtitle?: string
}

const props = withDefaults(defineProps<PageTitleProps>(), {
  title: '',
  subtitle: '',
})
const router = useRouter()
const showBackButton = computed(() => {
  return history.length > 1 && history.state.back !== null
})
</script>
