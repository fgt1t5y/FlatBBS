<template>
  <MainContent>
    <PageTitle title="设置" />
    <div class="settings-group">
      <NH6>
        <NText type="primary">头像</NText>
      </NH6>
      <SettingItem title="我的头像" subtitle="头像更新可能会有延迟">
        <NSpace align="end" justify="space-between">
          <NAvatar :src="info.avatar_uri" :size="64" round />
          <NButton
            type="primary"
            title="点击打开文件浏览器选择头像"
            @click="openAvatarSelector"
          >
            更改...
          </NButton>
        </NSpace>
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
      <NH6>
        <NText type="primary">用户资料</NText>
      </NH6>
      <SettingItem title="电子邮箱地址" subtitle="电子邮箱地址不允许修改">
        <InputField :input-value="info.email" readonly />
      </SettingItem>
      <SettingItem title="用户名">
        <InputField field="username" :input-value="info.username" />
      </SettingItem>
      <SettingItem title="简短介绍" subtitle="使用简短的言语介绍自己">
        <InputField field="introduction" :input-value="info.introduction" />
      </SettingItem>
    </div>
    <div class="settings-group">
      <NH6>
        <NText type="primary">显示</NText>
      </NH6>
      <SettingItem title="颜色主题" subtitle="网站全局显示的颜色主题">
        <CardRadio
          label="跟随系统模式"
          :checked="theme === 'auto'"
          @click="switchTo('auto')"
        >
          <Brightness1Icon size="18px" />
        </CardRadio>
        <CardRadio
          label="浅色模式"
          :checked="theme === 'light'"
          @click="switchTo('light')"
        >
          <ModeLightIcon size="18px" />
        </CardRadio>
        <CardRadio
          label="暗色模式"
          :checked="theme === 'dark'"
          @click="switchTo('dark')"
        >
          <ModeDarkIcon size="18px" />
        </CardRadio>
      </SettingItem>
    </div>
  </MainContent>
  <UserWindow
    :visible="isShowCropper"
    title="编辑头像"
    @ok="uploadAvatar"
    @cancle="closeAvatarCrop"
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
import CardRadio from '@/components/CardRadio.vue'
import { useTheme, useUserStore } from '@/stores'
import { blobToFile, getAvatarPath } from '@/utils'
import { NAvatar, NButton, NH6, NSpace, NText } from 'naive-ui'
import { ref } from 'vue'
import { uploadAsAvatar } from '@/services'
import UserWindow from '@/components/UserWindow.vue'
import '@/style/SettingsView.css'
import {
  Brightness1Icon,
  ModeLightIcon,
  ModeDarkIcon,
} from 'tdesign-icons-vue-next'
import MainContent from '@/components/MainContent.vue'

const { info } = useUserStore()
const { switchTo, theme } = useTheme()
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
const showCropperMessage = (content: string) => {
  window.$message.error(content)
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
        if (res.data.code > window.$code.OK) return
        info.avatar_uri = getAvatarPath(res.data.data!.uri)
        window.$message.success(
          '头像已上传。因为缓存的存在，生效时间可能延后。',
        )
      })
    }
  })

  closeAvatarCrop()
}
</script>
