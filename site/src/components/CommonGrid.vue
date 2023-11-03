<template>
  <Row>
    <Col flex="200px" class="grid-sider">
      <slot name="sider" />
    </Col>
    <Col flex="auto" class="grid-content">
      <slot name="content" />
    </Col>
    <Col flex="250px" class="grid-panels">
      <slot name="panels" />
    </Col>
  </Row>
</template>

<script setup lang="ts">
import { Row, Col } from '@arco-design/web-vue'
import '@/style/CommonGrid.css'

defineOptions({
  name: 'CommonGrid',
})
</script>
