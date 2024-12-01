<template>
  <div class="page-title border-bt" :title="title">
    <div class="flex gap-2 w-full items-center">
      <NButton
        v-if="showBackButton"
        title="返回上一级页面或回到首页"
        secondary
        circle
        size="large"
        @click="page.back"
      >
        <ArrowLeft class="size-6"/>
      </NButton>
      <div class="flex flex-col grow">
        <slot>
          <div class="font-bold text-xl">{{ title }}</div>
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
import { NButton } from 'naive-ui'
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
