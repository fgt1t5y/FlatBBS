<template>
  <MainContent>
    <PageTitle title="设置" />
    <div class="settings-group">
      <NH6>
        <NText type="primary">头像</NText>
      </NH6>
      <SettingItem title="我的头像" subtitle="头像更新可能会有延迟">
        <NSpace align="center" justify="space-between">
          <NAvatar :src="user.info?.avatar_uri" :size="64" round />
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
        <InputField :input-value="user.info?.email" readonly />
      </SettingItem>
      <SettingItem title="用户名" subtitle="用户名不允许修改">
        <InputField
          field="username"
          :input-value="user.info?.username"
          readonly
        />
      </SettingItem>
      <SettingItem title="昵称" subtitle="昵称会显示在大多数地方">
        <InputField
          field="display_name"
          :input-value="user.info?.display_name"
        />
      </SettingItem>
      <SettingItem title="简短介绍" subtitle="使用简短的言语介绍自己">
        <InputField
          field="introduction"
          :input-value="user.info?.introduction"
        />
      </SettingItem>
    </div>
    <div class="settings-group">
      <NH6>
        <NText type="primary">安全与隐私</NText>
      </NH6>
      <SettingItem title="密码" subtitle="登录时使用的密钥，请勿泄露">
        <div>
          <NButton type="primary" title="更改密码">更改</NButton>
        </div>
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
  <NModal
    v-model:show="isShowCropper"
    style="width: 368px"
    title="裁剪头像"
    preset="card"
    @before-leave="closeAvatarCrop"
  >
    <Cropper
      ref="cropper"
      :height="320"
      :width="320"
      :image="avatarFile"
      @error="showCropperMessage"
    />
    <NSpace :vertical="true">
      <NButton type="primary" block @click="uploadAvatar">确定</NButton>
    </NSpace>
  </NModal>
</template>

<script setup lang="ts">
import Cropper from '@/components/Cropper.vue'
import InputField from '@/components/InputField.vue'
import SettingItem from '@/components/SettingItem.vue'
import PageTitle from '@/components/PageTitle.vue'
import CardRadio from '@/components/CardRadio.vue'
import { useTheme, useUserStore } from '@/stores'
import { blobToFile } from '@/utils'
import { NAvatar, NButton, NH6, NSpace, NText, NModal } from 'naive-ui'
import { ref } from 'vue'
import { uploadAsAvatar } from '@/services'
import '@/style/SettingsView.css'
import {
  Brightness1Icon,
  ModeLightIcon,
  ModeDarkIcon,
} from 'tdesign-icons-vue-next'
import MainContent from '@/components/MainContent.vue'

const user = useUserStore()
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
    isShowCropper.value = true
  }
}
const showCropperMessage = (content: string) => {
  isShowCropper.value = false
  window.$message.error(content)
}
const closeAvatarCrop = () => {
  cropper.value?.destoryCropper()
  isShowCropper.value = false
}
const uploadAvatar = () => {
  cropper.value!.getBlobAsync().then((blob) => {
    if (blob) {
      const file = blobToFile(blob, '_.jpg')
      uploadAsAvatar(file).then((res) => {
        if (res.data.code > window.$code.OK) return
        window.$message.success(
          '头像已上传。因为缓存的存在，生效时间可能延后。',
        )
      })
    }
  })

  closeAvatarCrop()
}
</script>
