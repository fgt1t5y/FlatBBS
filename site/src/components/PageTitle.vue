<template>
  <div class="page-title">
    <div class="page-header">
      <div>
        <button
          v-show="showBackButton"
          class="icon-link hover-card"
          @click="backPage"
        >
          <IconArrowLeft :size="20" />
        </button>
        <TypographyTitle :heading="5">{{ title }}</TypographyTitle>
      </div>
      <slot name="extra" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { TypographyTitle } from '@arco-design/web-vue'
import '@/style/PageTitle.css'
import { IconArrowLeft } from '@arco-design/web-vue/es/icon'
import { useRouter, useRoute } from 'vue-router'
import { ref, onMounted, watch } from 'vue'

defineOptions({
  name: 'PageTitle',
})

interface PageTitleProps {
  title: string
}

const props = withDefaults(defineProps<PageTitleProps>(), {
  title: '',
})
const route = useRoute()
const router = useRouter()
const backPage = () => {
  if (!history.state.back || !canBack()) {
    router.push({ path: '/' })
    return
  }
  router.back()
}
const canBack = () => {
  return route.path !== '/'
}
const showBackButton = ref<boolean>(false)

watch(
  () => route.fullPath,
  () => {
    showBackButton.value = canBack()
  },
)

onMounted(() => {
  showBackButton.value = canBack()
})
</script>
