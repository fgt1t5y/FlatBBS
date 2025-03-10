<template>
  <MainContent disable-panels :title="$t('page.modify_avatar')">
    <PageTitle :title="$t('page.modify_avatar')" />
    <div
      v-show="isCropping"
      class="flex flex-col items-center gap-2 border-bt p-3"
    >
      <span class="font-bold">{{ $t('action.crop_avatar') }}</span>
      <Cropper
        ref="cropperRef"
        :height="320"
        :width="320"
        :image="avatarFile"
        @load="isCropping = true"
        @error="showCropperMessage"
      />
      <div class="flex gap-2">
        <button
          class="btn-air btn-md"
          :disabled="uploading"
          @click="isCropping = false"
        >
          {{ $t('cancle') }}
        </button>
        <button
          class="btn-primary btn-md"
          :disabled="uploading"
          @click="uploadAvatar"
        >
          {{ $t('ok') }}
        </button>
      </div>
    </div>
    <div
      v-show="!isCropping"
      class="flex flex-col items-center gap-2 border-bt p-3"
    >
      <span class="font-bold">{{ $t('message.current_avatar') }}</span>
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
import { ref, useTemplateRef } from 'vue'
import { modifyUserAvatar } from '@/services'
import { blobToFile } from '@/utils'
import { useI18n } from 'vue-i18n'
import { useRequest } from 'alova/client'

const user = useUserStore()
const ms = useMessage()
const { t } = useI18n()

const isCropping = ref<boolean>(false)
const avatarFile = ref<File>()
const avatarInputRef = ref<HTMLInputElement>()
const cropper = useTemplateRef('cropperRef')

const { loading: uploading, send } = useRequest(
  (file: File) => modifyUserAvatar(file),
  {
    immediate: false,
  },
)
  .onSuccess(() => {
    ms.success(t('message.upload_avatar_success'))
    user.fetch()
    closeAvatarCrop()
  })
  .onError(() => {
    ms.error(t('message.upload_avatar_fail'))
  })

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

const uploadAvatar = async () => {
  const blob = await cropper.value!.getBlobAsync()

  if (blob) {
    const file = blobToFile(blob, '_.jpg')

    await send(file)
  }
}
</script>
