<template>
  <div class="board-group">
    <button class="board-group-item" @click="loadBoards">
      <IconRight v-if="!isOpen" />
      <IconDown v-else />
      <TypographyText bold>{{ groupName }}</TypographyText>
      <IconLoading v-show="isLoading" />
    </button>
    <div v-if="isLoaded && isOpen" class="board-item">
      <span v-for="i in data">
        <RouterLink
          class="board-link hover-card"
          :style="{ color: i.color }"
          :to="idToUri(i.id)"
        >
          {{ i.name }}
        </RouterLink>
      </span>
    </div>
  </div>
</template>

<script setup lang="ts">
import { getBoardById } from '@/services'
import type { Board } from '@/types'
import { TypographyText } from '@arco-design/web-vue'
import { IconRight, IconDown, IconLoading } from '@arco-design/web-vue/es/icon'
import { ref } from 'vue'

defineOptions({
  name: 'BoardTreeNode',
})

interface BoardTreeNodeProps {
  groupId: number
  groupName: string
}

const props = withDefaults(defineProps<BoardTreeNodeProps>(), {
  groupId: 0,
  groupName: '',
})
const data = ref<Board[] | null>(null)
const isOpen = ref<boolean>(false)
const isLoading = ref<boolean>(false)
const isLoaded = ref<boolean>(false)
const idToUri = (id: number) => {
  return '/board/' + String(id)
}
const loadBoards = () => {
  if (isLoaded.value) {
    isOpen.value = !isOpen.value
    return
  }
  isLoading.value = true
  getBoardById(props.groupId)
    .then((res) => {
      if (res.data.code === 0) {
        data.value = res.data.data!
        isLoaded.value = true
        isOpen.value = true
      }
    })
    .finally(() => {
      isLoading.value = false
    })
}
</script>
