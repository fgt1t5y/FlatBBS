<template>
  <component :is="is || 'article'" class="html-rendered">
    <component :is="vnode" />
  </component>
</template>

<script setup lang="ts">
import { computed, h, Fragment } from 'vue'
import { parse, TEXT_NODE } from 'ultrahtml'
import { sanitizer } from '@/utils'

import type { VNode } from 'vue'
import type { Node } from 'ultrahtml'

defineOptions({
  name: 'ContentRenderer',
})

const props = defineProps<{
  html: string
  is?: string
}>()

const treeToVNode = (input: Node): VNode | string | null => {
  if (!input) {
    return null
  }

  if (input.type === TEXT_NODE) {
    // return decode(input.value)
    return input.value
  }

  if ('children' in input) {
    return nodeToVNode(input)
  }
  return null
}

const nodeToVNode = (node: Node): VNode | string | null => {
  if (node.type === TEXT_NODE) {
    return node.value
  }

  if ('children' in node) {
    return h(node.name, node.attributes, node.children.map(treeToVNode))
  }
  return null
}

const contentToVNode = (html: string): VNode => {
  const tree = sanitizer(parse(html))

  return h(
    Fragment,
    ((tree.children as Node[]) || []).map((n) => treeToVNode(n)),
  )
}

const vnode = computed(() => {
  if (!props.html) {
    return null
  }

  return contentToVNode(props.html)
})
</script>
