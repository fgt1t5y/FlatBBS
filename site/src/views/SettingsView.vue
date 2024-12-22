<template>
  <MainContent disable-panels :title="$t('page.settings')">
    <PageTitle :title="$t('page.settings')" />
    <SettingGroup :title="$t('settings.user_profile')">
      <SettingItem :title="$t('settings.my_avatar')">
        <div class="flex justify-between">
          <Avatar class="size-16" :src="user.info?.avatar_uri" rounded />
          <button class="btn-primary btn-md" @click="openAvatarSelector">
            {{ $t('action.modify') }}
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
      <SettingItem :title="$t('settings.email_address')">
        <InputField :input-value="user.info?.email" readonly />
      </SettingItem>
      <SettingItem :title="$t('settings.username')">
        <InputField
          field="username"
          :input-value="user.info?.username"
          readonly
        />
      </SettingItem>
      <SettingItem :title="$t('settings.user_roles')">
        <span>{{ roleStringify() }}</span>
      </SettingItem>
      <SettingItem :title="$t('settings.display_name')">
        <InputField
          field="display_name"
          :input-value="user.info?.display_name"
        />
      </SettingItem>
      <SettingItem :title="$t('settings.introduction')">
        <InputField
          field="introduction"
          :input-value="user.info?.introduction"
        />
      </SettingItem>
    </SettingGroup>
    <SettingGroup :title="$t('settings.security_and_privacy')">
      <SettingItem :title="$t('password')">
        <RouterLink :to="{ name: 'modify_password' }">
          <button class="btn-primary btn-md">
            {{ $t('action.modify') }}
          </button>
        </RouterLink>
      </SettingItem>
    </SettingGroup>
    <SettingGroup :title="$t('settings.display')">
      <SettingItem :title="$t('settings.language')">
        <FormKit v-model="locale" type="select" :options="availableLocales" />
      </SettingItem>
      <SettingItem :title="$t('settings.theme_mode')">
        <FormKit
          v-model="themeSwitcherValue"
          type="radio"
          decorator-icon="circle"
          :options="{
            auto: $t('settings.follow_system'),
            light: $t('settings.light'),
            dark: $t('settings.dark'),
          }"
        />
      </SettingItem>
    </SettingGroup>
  </MainContent>
  <Modal
    v-model:visible="isShowCropper"
    mount
    :title="$t('action.crop_avatar')"
  >
    <Cropper
      ref="cropper"
      :height="320"
      :width="320"
      :image="avatarFile"
      @load="isShowCropper = true"
      @error="showCropperMessage"
    />
    <div class="flex flex-col gap-2 mt-2">
      <button class="btn-primary btn-md" @click="uploadAvatar">
        {{ $t('ok') }}
      </button>
      <button class="btn-air btn-md" @click="closeAvatarCrop">
        {{ $t('cancle') }}
      </button>
    </div>
  </Modal>
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
import Modal from '@/components/Modal.vue'
import { useI18n } from 'vue-i18n'

const user = useUserStore()
const ms = useMessage()
const { t, locale, availableLocales } = useI18n()
const { switchTo, theme } = useTheme()
const cropper = ref<InstanceType<typeof Cropper>>()
const isShowCropper = ref<boolean>(false)
const avatarInput = ref<HTMLInputElement>()
const avatarFile = ref<File>()
const themeSwitcherValue = ref(theme.value)

const openAvatarSelector = () => {
  avatarInput.value?.click()
}

const giveAvatarFile = () => {
  if (avatarInput.value?.files) {
    avatarFile.value = avatarInput.value!.files[0]
  }
}

const showCropperMessage = (content: string) => {
  isShowCropper.value = false
  ms.error(content)
}

const closeAvatarCrop = () => {
  cropper.value?.destroyCropper()
  isShowCropper.value = false
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

const roleStringify = () => {
  return user.info?.roles.map((role) => role.name).join(', ')
}

watch(
  () => themeSwitcherValue.value,
  (tm) => {
    if (!tm) return

    switchTo(tm)
  },
)
</script>
