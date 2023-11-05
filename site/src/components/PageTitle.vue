<template>
  <div class="page-header" :title="title">
    <button
      v-show="showBackButton && showBack"
      class="icon-link hover-card"
      title="返回上一级页面或回到首页"
      @click="backPage"
    >
      <IconArrowLeft :size="20" />
    </button>
    <div>
      <slot>{{ title }}</slot>
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/style/PageTitle.css'
import { IconArrowLeft } from '@arco-design/web-vue/es/icon'
import { useRouter, useRoute } from 'vue-router'
import { ref, onMounted, watch } from 'vue'

defineOptions({
  name: 'PageTitle',
})

interface PageTitleProps {
  title: string
  showBack?: boolean
}

const props = withDefaults(defineProps<PageTitleProps>(), {
  title: '',
  showBack: true,
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
