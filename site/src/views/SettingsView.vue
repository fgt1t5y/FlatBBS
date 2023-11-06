<template>
  <PageTitle title="设置" />
  <div class="settings-group">
    <NH6>头像</NH6>
    <SettingItem title="我的头像" subtitle="点击以更改。">
      <NAvatar
        :src="info.avatar_uri"
        :size="64"
        round
        @click="openAvatarSelector"
      />
      <input
        ref="avatarInput"
        type="file"
        name="avatar"
        accept=".jpg,.png,.jpeg"
        style="display: none"
        @change="giveAvatarFile"
      />
    </SettingItem>
  </div>
  <div class="settings-group">
    <NH6 :heading="6">用户资料</NH6>
    <SettingItem title="电子邮箱地址" subtitle="电子邮箱地址不允许修改。">
      <InputField :input-value="info.email" readonly />
    </SettingItem>
    <SettingItem title="用户名">
      <InputField field="username" :input-value="info.username" />
    </SettingItem>
    <SettingItem title="简短介绍" subtitle="使用简短的言语介绍自己。">
      <InputField field="introduction" :input-value="info.introduction" />
    </SettingItem>
  </div>
  <UserWindow
    :visible="isShowCropper"
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
  </UserWindow>
</template>

<script setup lang="ts">
import Cropper from '@/components/Cropper.vue'
import InputField from '@/components/InputField.vue'
import SettingItem from '@/components/SettingItem.vue'
import PageTitle from '@/components/PageTitle.vue'
import { useUserStore } from '@/stores'
import { blobToFile, getAvatarPath } from '@/utils'
import { NAvatar, NH6, useMessage } from 'naive-ui'
import { ref } from 'vue'
import { uploadAsAvatar } from '@/services'
import UserWindow from '@/components/UserWindow.vue'

import '@/style/SettingsView.css'

const { info } = useUserStore()
const message = useMessage()
const cropper = ref<InstanceType<typeof Cropper>>()
const isShowCropper = ref<boolean>(false)
const avatarInput = ref<HTMLInputElement>()
const avatarFile = ref<File>()
const openAvatarSelector = () => {
  avatarInput.value!.click()
}
const giveAvatarFile = () => {
  if (avatarInput.value?.files) {
    console.log('here')
    avatarFile.value = avatarInput.value!.files[0]
  }
}
const showCropper = () => {
  isShowCropper.value = true
}
const showCropperMessage = (content: string) => {
  message.error(content)
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
          info.avatar_uri = getAvatarPath(res.data.data!.uri)
          message.success('头像已上传。因为缓存的存在，生效时间可能延后。')
        }
      })
    }
  })

  closeAvatarCrop()
}
</script>
