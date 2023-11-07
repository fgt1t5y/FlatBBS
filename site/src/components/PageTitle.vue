<template>
  <div class="page-header" :title="title">
    <NButton
      v-show="showBackButton && showBack"
      circle
      secondary
      title="返回上一级页面或回到首页"
      @click="page.back"
    >
      <ArrowLeftIcon size="18px" />
    </NButton>
    <div>
      <slot>{{ title }}</slot>
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/style/PageTitle.css'
import { ArrowLeftIcon } from 'tdesign-icons-vue-next'
import { NButton } from 'naive-ui'
import { ref, watch, computed } from 'vue'
import { usePage } from '@/utils/usePage'

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
const page = usePage()
const currentFullPath = ref<string>(page.path.value)
const showBackButton = computed(
  () => props.showBack && currentFullPath.value !== '/',
)

watch(
  () => page.path.value,
  (v) => {
    currentFullPath.value = v
  },
)
</script>
