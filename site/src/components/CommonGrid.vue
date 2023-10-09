<template>
  <Row>
    <Col flex="200px" :class="siderClass">
      <slot name="sider" />
    </Col>
    <Col flex="auto" class="grid-content">
      <slot name="content" />
    </Col>
  </Row>
</template>

<script setup lang="ts">
import { Row, Col } from '@arco-design/web-vue'
import { computed } from 'vue'

defineOptions({
  name: 'CommonGrid',
})

interface CommonGridProps {
  siderPosition?: 'left' | 'right'
}

const props = withDefaults(defineProps<CommonGridProps>(), {
  siderPosition: 'left',
})
const siderClass = computed(() => {
  return {
    'grid-sider': true,
    'grid-revert': props.siderPosition === 'right',
  }
})
</script>

<style>
.arco-row {
  gap: 16px;
}

.grid-revert {
  order: 1;
}

.grid-sider {
  display: flex;
  flex-direction: column;
}
</style>
