<template>
  <MainContent>
    <PageTitle title="设置" />
    <SettingGroup title="头像">
      <SettingItem title="我的头像" subtitle="头像更新可能会有延迟">
        <NFlex align="center" justify="space-between">
          <NAvatar :src="user.info?.avatar_uri" :size="64" round />
          <NButton
            type="primary"
            title="点击打开文件浏览器选择头像"
            @click="openAvatarSelector"
          >
            更改...
          </NButton>
        </NFlex>
        <input
          ref="avatarInput"
          type="file"
          name="avatar"
          accept=".jpg,.png,.jpeg"
          style="display: none"
          @change="giveAvatarFile"
        />
      </SettingItem>
    </SettingGroup>
    <SettingGroup title="用户资料">
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
    </SettingGroup>
    <SettingGroup title="安全与隐私">
      <SettingItem title="密码" subtitle="登录时使用的密钥，请勿泄露">
        <div>
          <NButton type="primary" title="更改密码">更改</NButton>
        </div>
      </SettingItem>
    </SettingGroup>
    <SettingGroup title="显示">
      <SettingItem title="颜色主题" subtitle="网站全局显示的颜色主题">
        <NRadioGroup
          class="n-radio-block"
          :value="theme"
          @update:value="switchTo"
        >
          <NRadioButton value="auto">跟随系统</NRadioButton>
          <NRadioButton value="light">浅色</NRadioButton>
          <NRadioButton value="dark">暗色</NRadioButton>
        </NRadioGroup>
      </SettingItem>
    </SettingGroup>
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
    <NFlex :vertical="true">
      <NButton type="primary" block @click="uploadAvatar">确定</NButton>
      <NButton block @click="closeAvatarCrop">取消</NButton>
    </NFlex>
  </NModal>
</template>

<script setup lang="ts">
import Cropper from '@/components/Cropper.vue'
import InputField from '@/components/InputField.vue'
import SettingItem from '@/components/SettingItem.vue'
import SettingGroup from '@/components/SettingGroup.vue'
import PageTitle from '@/components/PageTitle.vue'
import { useTheme, useUserStore } from '@/stores'
import { blobToFile } from '@/utils'
import {
  NAvatar,
  NButton,
  NModal,
  NFlex,
  NRadioGroup,
  NRadioButton,
} from 'naive-ui'
import { ref } from 'vue'
import { modifyUserAvatar } from '@/services'
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
      modifyUserAvatar(file).then((res) => {
        if (res.code > window.$code.OK) return
        window.$message.success('头像已上传')
      })
    }
  })

  closeAvatarCrop()
}
</script>
