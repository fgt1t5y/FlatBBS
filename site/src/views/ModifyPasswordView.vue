<template>
  <MainContent disable-panels :title="$t('page.modify_password')">
    <PageTitle :title="$t('page.modify_password')" />
    <div class="p-3 my-0 mx-auto" style="max-width: 500px">
      <CommonForm :form="modifyForm" @submit="actionSubmit">
        <FormInput
          v-model="modifyForm.old_password"
          autocomplete="current-password"
          type="password"
          name="old_password"
          :label="$t('old_password')"
          :min="8"
          required
        />
        <FormInput
          v-model="modifyForm.new_password"
          autocomplete="new-password"
          type="password"
          name="new_password"
          :label="$t('new_password')"
          :min="8"
          required
        />
        <FormInput
          v-model="modifyForm.new_password_confirm"
          autocomplete="new-password"
          type="password"
          name="new_password_confirm"
          :label="$t('new_password_confirm')"
          :validator="checkPasswordSame"
          :min="8"
          required
        />
      </CommonForm>
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import { modifyPassword } from '@/services'
import { useMessage } from '@/stores'
import { clearToken } from '@/utils'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import CommonForm from '@/components/CommonForm.vue'
import FormInput from '@/components/form/FormInput.vue'
import { useI18n } from 'vue-i18n'

const router = useRouter()
const ms = useMessage()
const { t } = useI18n()
const isDealing = ref<boolean>(false)
const modifyForm = ref({
  old_password: '',
  new_password: '',
  new_password_confirm: '',
})

const checkPasswordSame = () => {
  if (
    modifyForm.value.new_password &&
    modifyForm.value.new_password_confirm !== modifyForm.value.new_password
  ) {
    return new Error(t('form.password_confirm_dismatch'))
  }

  return true
}

const actionSubmit = () => {
  isDealing.value = true

  modifyPassword(modifyForm.value.old_password, modifyForm.value.new_password)
    .then(() => {
      clearToken()
      router.replace({ name: 'home' }).then(() => {
        location.reload()
      })
    })
    .catch((error: Error) => {
      ms.error(error.message)
    })
    .finally(() => {
      isDealing.value = false
    })
}
</script>
