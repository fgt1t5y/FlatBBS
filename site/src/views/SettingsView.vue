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
            <Avatar
              :image-url="info.avatar_uri"
              :size="64"
              @click="openAvatarSelector"
            >
              <template #trigger-icon>
                <IconEdit />
              </template>
            </Avatar>
            <input
              ref="avatarInput"
              type="file"
              name="avatar"
              style="display: none"
              @change="giveAvatarFile"
            />
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
  <Modal
    :visible="showAvatarCropper"
    :width="360"
    title="编辑头像"
    @cancel="cancleAvatarCrop"
  >
    <div>
      <AvatarCropper ref="cropper" :image="avatarFile" />
    </div>
  </Modal>
</template>

<script setup lang="ts">
import AvatarCropper from '@/components/AvatarCropper.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import InputField from '@/components/InputField.vue'
import SettingField from '@/components/SettingField.vue'
import { useUserStore } from '@/stores'
import { TypographyText, Avatar, Modal } from '@arco-design/web-vue'
import { IconEdit } from '@arco-design/web-vue/es/icon'
import './SettingView.css'
import { ref } from 'vue'

const { info } = useUserStore()
const cropper = ref<InstanceType<typeof AvatarCropper>>()
const showAvatarCropper = ref<boolean>(false)
const avatarInput = ref<HTMLInputElement>()
const avatarFile = ref<File>()
const openAvatarSelector = () => {
  avatarInput.value!.click()
}
const giveAvatarFile = () => {
  if (avatarInput.value?.files) {
    avatarFile.value = avatarInput.value!.files[0]
    showAvatarCropper.value = true
  }
}
const cancleAvatarCrop = () => {
  showAvatarCropper.value = false
  cropper.value?.destoryCropper()
}
</script>
