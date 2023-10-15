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
        <TypographyTitle :heading="6">头像</TypographyTitle>
        <SettingField title="我的头像" subtitle="点击以更改。">
          <Avatar
            :image-url="info.avatar_uri"
            :size="64"
            @click="openAvatarSelector"
          />
          <input
            ref="avatarInput"
            type="file"
            name="avatar"
            accept=".jpg,.png,.webp"
            style="display: none"
            @change="giveAvatarFile"
          />
        </SettingField>
      </div>
      <div class="settings-group">
        <TypographyTitle :heading="6">用户资料</TypographyTitle>
        <SettingField title="电子邮箱地址" subtitle="电子邮箱地址不允许修改。">
          <InputField :input-value="info.email" readonly />
        </SettingField>
        <SettingField title="用户名">
          <InputField field="username" :input-value="info.username" />
        </SettingField>
        <SettingField title="简短介绍" subtitle="使用简短的言语介绍自己。">
          <InputField field="introduction" :input-value="info.introduction" />
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
      <Cropper
        ref="cropper"
        :height="320"
        :width="320"
        :image="avatarFile"
        @load="showCropper"
        @error="showCropperMessage"
      />
    </div>
  </Modal>
</template>

<script setup lang="ts">
import Cropper from '@/components/Cropper.vue'
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
import { ref } from 'vue'
import { uploadAsAvatar } from '@/services'

const { info } = useUserStore()
const cropper = ref<InstanceType<typeof Cropper>>()
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
      uploadAsAvatar(file).then((res) => {
        if (res.data.code === 0) {
          info.avatar_uri = res.data.data!.uri
          Modal.success({
            content: '头像已上传。因为缓存的存在，生效时间可能延后。',
          })
        }
      })
    }
  })

  closeAvatarCrop()
}
</script>
