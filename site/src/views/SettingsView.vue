<template>
  <CommonGrid sider-position="right">
    <template #sider></template>
    <template #content>
      <Space direction="vertical" :size="0">
        <TypographyTitle :heading="4" style="margin: unset">
          设置
        </TypographyTitle>
        <TypographyText type="secondary">
          在此页面调整用户名、密码、主题模式等设置。
        </TypographyText>
      </Space>
      <div class="settings-group">
        <TypographyTitle :heading="6">用户资料</TypographyTitle>
        <SettingField title="头像" subtitle="点击以更改。">
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
            accept=".jpg,.png,.webp"
            style="display: none"
            @change="giveAvatarFile"
          />
        </SettingField>
        <SettingField title="电子邮箱地址" subtitle="电子邮箱地址不允许修改。">
          <TypographyText>{{ info.email }}</TypographyText>
        </SettingField>
        <SettingField title="用户名">
          <InputField :input-value="info.username" />
        </SettingField>
      </div>
    </template>
  </CommonGrid>
  <Modal
    :visible="isShowCropper"
    :width="360"
    title="编辑头像"
    @ok="uploadAvatar"
    @cancel="closeAvatarCrop"
  >
    <div>
      <AvatarCropper
        ref="cropper"
        :image="avatarFile"
        @load="showCropper"
        @error="showCropperMessage"
      />
    </div>
  </Modal>
</template>

<script setup lang="ts">
import AvatarCropper from '@/components/AvatarCropper.vue'
import CommonGrid from '@/components/CommonGrid.vue'
import InputField from '@/components/InputField.vue'
import SettingField from '@/components/SettingField.vue'
import { useUserStore } from '@/stores'
import { blobToFile } from '@/utils'
import {
  TypographyText,
  TypographyTitle,
  Avatar,
  Modal,
  Message,
  Space,
} from '@arco-design/web-vue'
import { IconEdit } from '@arco-design/web-vue/es/icon'
import { ref } from 'vue'
import { uploadAsAvatar } from '@/services'

const { info } = useUserStore()
const cropper = ref<InstanceType<typeof AvatarCropper>>()
const isShowCropper = ref<boolean>(false)
const avatarInput = ref<HTMLInputElement>()
const avatarFile = ref<File>()
const openAvatarSelector = () => {
  avatarInput.value!.click()
}
const giveAvatarFile = () => {
  if (avatarInput.value?.files) {
    avatarFile.value = avatarInput.value!.files[0]
  }
}
const showCropper = () => {
  isShowCropper.value = true
}
const showCropperMessage = (message: string) => {
  Message.error(message)
}
const closeAvatarCrop = () => {
  isShowCropper.value = false
  cropper.value?.destoryCropper()
}
const uploadAvatar = () => {
  cropper.value!.getBlobAsync().then((blob) => {
    if (blob) {
      const file = blobToFile(blob, '_.jpg')
      uploadAsAvatar(file)
    }
  })

  closeAvatarCrop()
}
</script>
