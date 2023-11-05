<template>
  <div class="topic-content" v-html="parsedText"></div>
</template>

<script setup lang="ts">
import { type ViewerProps, getProcessor } from 'bytemd'
import { ref, onMounted } from 'vue'

defineOptions({
  name: 'MDViewer',
})

const props = withDefaults(defineProps<ViewerProps>(), {
  value: '# Nothing',
  plugins: () => [],
  sanitize: (t: any) => t,
})
const parsedText = ref<string>('')

onMounted(() => {
  parsedText.value = getProcessor(props).processSync(props.value).value
})
</script>
