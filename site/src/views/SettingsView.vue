<template>
  <MainContent disable-panels>
    <PageTitle title="设置" />
    <SettingGroup title="用户资料">
      <SettingItem title="我的头像" subtitle="头像更新可能会有延迟">
        <div class="flex justify-between">
          <Avatar class="size-16" :src="user.info?.avatar_uri" rounded />
          <button class="btn btn-primary btn-md" @click="openAvatarSelector">
            更改...
          </button>
        </div>
        <input
          ref="avatarInput"
          type="file"
          name="avatar"
          accept=".jpg,.png,.jpeg"
          style="display: none"
          @change="giveAvatarFile"
        />
      </SettingItem>
      <SettingItem title="电子邮箱地址">
        <InputField :input-value="user.info?.email" readonly />
      </SettingItem>
      <SettingItem title="用户名">
        <InputField
          field="username"
          :input-value="user.info?.username"
          readonly
        />
      </SettingItem>
      <SettingItem title="昵称">
        <InputField
          field="display_name"
          :input-value="user.info?.display_name"
        />
      </SettingItem>
      <SettingItem title="简短介绍">
        <InputField
          field="introduction"
          :input-value="user.info?.introduction"
        />
      </SettingItem>
    </SettingGroup>
    <SettingGroup title="安全与隐私">
      <SettingItem title="密码">
        <div>
          <button class="btn btn-primary btn-md">更改</button>
        </div>
      </SettingItem>
    </SettingGroup>
    <SettingGroup title="显示">
      <SettingItem title="颜色主题" subtitle="网站全局显示的颜色主题">
        <FormKit
          v-model="themeSwitcherValue"
          type="radio"
          :options="{ auto: 'Auto', light: 'Light', dark: 'Dark' }"
        />
      </SettingItem>
    </SettingGroup>
  </MainContent>
</template>

<script setup lang="ts">
import Cropper from '@/components/Cropper.vue'
import InputField from '@/components/InputField.vue'
import SettingItem from '@/components/SettingItem.vue'
import SettingGroup from '@/components/SettingGroup.vue'
import PageTitle from '@/components/PageTitle.vue'
import { useMessage, useTheme, useUserStore } from '@/stores'
import { blobToFile } from '@/utils'
import { ref, watch } from 'vue'
import { modifyUserAvatar } from '@/services'
import MainContent from '@/components/MainContent.vue'
import { FormKit } from '@formkit/vue'
import Avatar from '@/components/Avatar.vue'

const user = useUserStore()
const ms = useMessage()
const { switchTo, theme } = useTheme()
const cropper = ref<InstanceType<typeof Cropper>>()
const isShowCropper = ref<boolean>(false)
const avatarInput = ref<HTMLInputElement>()
const avatarFile = ref<File>()
const themeSwitcherValue = ref(theme.value)

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
  ms.error(content)
}

const closeAvatarCrop = () => {
  cropper.value?.destoryCropper()
  isShowCropper.value = false
}

const uploadAvatar = () => {
  cropper.value!.getBlobAsync().then((blob) => {
    if (blob) {
      const file = blobToFile(blob, '_.jpg')
      modifyUserAvatar(file)
        .then(() => {
          ms.success('头像已上传')
        })
        .catch(() => {
          ms.error('头像更新失败')
        })
    }
  })

  closeAvatarCrop()
}

watch(
  () => themeSwitcherValue.value,
  (tm) => {
    if (!tm) return

    switchTo(tm)
  },
)
</script>
