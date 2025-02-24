<template>
  <MainContent disable-panels :title="$t('page.modify_avatar')">
    <PageTitle :title="$t('page.modify_avatar')" />
    <div
      v-show="isCropping"
      class="flex flex-col items-center gap-1 border-bt p-3"
    >
      <Cropper
        ref="cropper"
        :height="320"
        :width="320"
        :image="avatarFile"
        @load="isCropping = true"
        @error="showCropperMessage"
      />
      <div class="flex gap-2 mt-2">
        <button class="btn-primary btn-md" @click="uploadAvatar">
          {{ $t('ok') }}
        </button>
        <button class="btn-air btn-md" @click="isCropping = false">
          {{ $t('cancle') }}
        </button>
      </div>
    </div>
    <div
      v-show="!isCropping"
      class="flex flex-col items-center gap-1 border-bt p-3"
    >
      <Avatar class="size-24" :src="user.info?.avatar_uri" rounded />
      <button class="btn-primary btn-md" @click="onePickImageClick">
        {{ $t('action.pick_image') }}
      </button>
    </div>
    <input
      ref="avatarInputRef"
      type="file"
      name="avatar"
      accept=".jpg,.png,.jpeg"
      style="display: none"
      @change="giveAvatarFile"
    />
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import Avatar from '@/components/Avatar.vue'
import Cropper from '@/components/Cropper.vue'
import { useMessage, useUserStore } from '@/stores'
import { ref } from 'vue'
import { modifyUserAvatar } from '@/services'
import { blobToFile } from '@/utils'
import { useI18n } from 'vue-i18n'

const user = useUserStore()
const ms = useMessage()
const { t } = useI18n()

const isCropping = ref<boolean>(false)
const avatarFile = ref<File>()
const avatarInputRef = ref<HTMLInputElement>()
const cropper = ref<InstanceType<typeof Cropper>>()

const onePickImageClick = () => {
  avatarInputRef.value?.click()
}

const giveAvatarFile = () => {
  if (avatarInputRef.value?.files) {
    avatarFile.value = avatarInputRef.value!.files[0]
  }
}

const showCropperMessage = (content: string) => {
  ms.error(content)
}

const closeAvatarCrop = () => {
  cropper.value?.destroyCropper()
  isCropping.value = false
  avatarInputRef.value!.value = ''
}

const uploadAvatar = () => {
  cropper.value!.getBlobAsync().then((blob) => {
    if (blob) {
      const file = blobToFile(blob, '_.jpg')
      modifyUserAvatar(file)
        .then(() => {
          ms.success(t('message.upload_avatar_success'))
        })
        .catch(() => {
          ms.error(t('message.upload_avatar_fail'))
        })
    }
  })

  closeAvatarCrop()
}
</script>
