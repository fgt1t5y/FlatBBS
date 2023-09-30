<template>
  <Row>
    <Col flex="200px" class="grid-sider">
      <slot name="sider" />
    </Col>
    <Col flex="auto">
      <slot name="content" />
    </Col>
  </Row>
</template>

<script setup lang="ts">
import { Row, Col } from "@arco-design/web-vue";

defineOptions({
  name: "CommonGrid",
});
</script>

<style>
.arco-col:first-child {
  padding-right: 8px;
}

.arco-col:last-child {
  padding-left: 8px;
}

.grid-sider {
  display: flex;
  flex-direction: column;
}
</style>
