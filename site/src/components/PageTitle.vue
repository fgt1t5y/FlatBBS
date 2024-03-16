<template>
  <div :class="pageTitleClass" :title="title">
    <div class="page-title-main">
      <NButton
        v-if="showBackButton"
        circle
        :type="float ? 'primary' : 'default'"
        :quaternary="!float"
        title="返回上一级页面或回到首页"
        @click="page.back"
      >
        <ArrowLeftIcon size="20px" />
      </NButton>
      <div class="page-title-default">
        <slot>
          <div class="page-title-title">{{ title }}</div>
          <NText :depth="3">{{ subtitle }}</NText>
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
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { usePage } from '@/utils'

defineOptions({
  name: 'PageTitle',
})

interface PageTitleProps {
  title: string
  subtitle?: string
  showBack?: boolean
  float?: boolean
}

const props = withDefaults(defineProps<PageTitleProps>(), {
  title: '未命名页面',
  subtitle: '',
  showBack: true,
  float: false,
})
const page = usePage()
const route = useRoute()
const showBackButton = computed(() => props.showBack && route.fullPath !== '/')
const pageTitleClass = computed(() => {
  return {
    'page-title': true,
    'page-title-float': props.float,
  }
})
</script>
