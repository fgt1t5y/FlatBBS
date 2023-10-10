<template>
  <CommonGrid sider-position="right">
    <template #sider></template>
    <template #content>
      <div>
        <div class="settings-title">设置</div>
        <TypographyText type="secondary">
          在此页面调整用户名、密码、主题模式等设置。
        </TypographyText>
      </div>
      <div class="settings-group">
        <h5 class="setting-group-title">用户资料</h5>
        <SettingField title="头像" subtitle="点击以更改。">
          <template #content>
            <Avatar :image-url="info.avatar_uri" :size="64">
              <template #trigger-icon>
                <IconEdit />
              </template>
            </Avatar>
            <AvatarCropper />
          </template>
        </SettingField>
        <InputField
          class="settings-field"
          label="用户名"
          :input-value="info.username"
        />
      </div>
    </template>
  </CommonGrid>
</template>

<script setup lang="ts">
import AvatarCropper from '@/components/AvatarCropper.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import InputField from '@/components/InputField.vue'
import SettingField from '@/components/SettingField.vue'
import { useUserStore } from '@/stores'
import { TypographyText, Avatar } from '@arco-design/web-vue'
import { IconEdit } from '@arco-design/web-vue/es/icon'

const { info } = useUserStore()
</script>
