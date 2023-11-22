<template>
  <div class="page-title" :title="title">
    <div class="page-title-main">
      <NButton
        v-show="showBackButton && showBack"
        class="page-title-back"
        circle
        quaternary
        title="返回上一级页面或回到首页"
        @click="page.back"
      >
        <ArrowLeftIcon size="20px" />
      </NButton>
      <div>
        <slot>
          <div class="page-title-default">
            <div class="page-title-title">{{ title }}</div>
            <NText :depth="3">{{ subtitle }}</NText>
          </div>
        </slot>
      </div>
    </div>
    <div class="page-title-extra">
      <slot name="extra" />
    </div>
  </div>
</template>

<script setup lang="ts">
import '@/style/PageTitle.css'
import { ArrowLeftIcon } from 'tdesign-icons-vue-next'
import { NButton, NText } from 'naive-ui'
import { ref, watch, computed } from 'vue'
import { usePage } from '@/utils/usePage'

defineOptions({
  name: 'PageTitle',
})

interface PageTitleProps {
  title: string
  subtitle?: string
  showBack?: boolean
}

const props = withDefaults(defineProps<PageTitleProps>(), {
  title: '',
  subtitle: '',
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
