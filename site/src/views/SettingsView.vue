<template>
  <CommonGrid sider-position="right">
    <template #sider></template>
    <template #content>
      <div class="settings-page">
        <div class="settings-title">设置</div>
        <TypographyText type="secondary">
          在此页面调整用户名、密码、主题模式等设置。
        </TypographyText>
      </div>
      <div id="user" class="settings-group">
        <h5 class="setting-group-title">用户资料</h5>
        <InputField label="用户名" :input-value="info.username" />
      </div>
    </template>
  </CommonGrid>
</template>

<script setup lang="ts">
import CommonGrid from '@/components/CommonGrid.vue'
import InputField from '@/components/InputField.vue'
import { useUserStore } from '@/stores'
import { TypographyText } from '@arco-design/web-vue'

const { info } = useUserStore()
</script>

<style>
.settings-title {
  font-size: 24px;
}

.setting-group-title {
  font-size: 16px;
  margin-bottom: 1rem;
}

.input-field {
  padding: 1rem 0px;
  border-top: 1px solid var(--color-neutral-3);
}

.input-field:last-child {
  border-bottom: 1px solid var(--color-neutral-3);
}
</style>
