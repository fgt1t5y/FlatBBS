<template>
  <Row>
    <Col flex="200px" class="grid-sider">
      <slot name="sider" />
    </Col>
    <Col flex="auto" class="grid-content">
      <slot name="content" />
    </Col>
    <Col flex="200px" class="grid-panels">
      <TypographyText type="secondary">欢迎使用 FlatBBS</TypographyText>
    </Col>
  </Row>
</template>

<script setup lang="ts">
import { Row, Col, TypographyText } from '@arco-design/web-vue'
import '@/style/CommonGrid.css'

defineOptions({
  name: 'CommonGrid',
})
</script>
