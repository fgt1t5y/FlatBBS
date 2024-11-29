<template>
  <div class="page-title border-b" :title="title">
    <div class="page-title-main">
      <NButton
        v-if="showBackButton"
        title="返回上一级页面或回到首页"
        secondary
        circle
        size="large"
        @click="page.back"
      >
        <NIcon :size="28" :component="ArrowLeft" />
      </NButton>
      <div class="page-title-default">
        <slot>
          <div class="page-title-title">{{ title }}</div>
        </slot>
      </div>
    </div>
    <div class="page-title-extra">
      <slot name="extra" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ArrowLeft } from '@vicons/tabler'
import { NButton, NIcon } from 'naive-ui'
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
