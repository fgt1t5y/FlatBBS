<template>
  <Row>
    <Col flex="200px">
      <slot name="sider" />
    </Col>
    <Col flex="auto">
      <slot name="content" />
    </Col>
  </Row>
</template>

<script setup lang="ts">
import { Row, Col } from "@arco-design/web-vue";
</script>
